<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Auth;

class DashboardController extends Controller
{
    public function index(Request $request){

        //BED_SEARCH
        $uri = env('BED_SEARCH');
        $client = new \GuzzleHttp\Client(['defaults' => ['verify' => false]]);

        $response = $client->request('GET', $uri);

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody(), true);

        $today = Carbon::today();
        $tomorrow = $today->copy()->addDay();
        $inThreeDays = $today->copy()->addDays(3);
        $inSevenDays = $today->copy()->addDays(7);

        $summary = [];

        foreach ($content["WardList"] as $ward) {
            $wardName = $ward['warddesc'] ?? $ward['wardcode'];
            $bedList = $ward['BedList'] ?? [];
            $nurseStation = $ward['NurseStation'] ?? [];

            if (empty($bedList) && empty($nurseStation)) {
                continue;
            }

            $todayCount = 0;
            $tomorrowCount = 0;
            $next3to7Count = 0;
            $totalBeds = count($bedList);
            $occupied = 0;
            $booked = 0;
            $unavailable = 0;

            foreach ($bedList as $bed) {
                if (!empty($bed['episodeno'])) {
                    $occupied++;
                }

                if (!empty($bed['bedstatus']) && strtolower($bed['bedstatus']) === 'unavailable') {
                    $unavailable++;
                }

                if (!empty($bed['estdisdate'])) {
                    try {
                        $estDate = Carbon::createFromFormat('d/m/Y', trim($bed['estdisdate']));
                        if ($estDate->isToday()) {
                            $todayCount++;
                        } elseif ($estDate->isTomorrow()) {
                            $tomorrowCount++;
                        } elseif ($estDate->between($inThreeDays, $inSevenDays)) {
                            $next3to7Count++;
                        }
                    } catch (\Exception $e) {
                        Log::error("Invalid estdisdate format: " . $bed['estdisdate'], [
                            'ward' => $wardName,
                            'bedno' => $bed['bedno'] ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        continue;
                    }
                }

                if (!empty($bed['BedRequestList']) && is_array($bed['BedRequestList'])) {
                    $booked++;
                }
            }

            foreach ($nurseStation as $nurse) {
                if (!empty($nurse['BedRequestList']) && is_array($nurse['BedRequestList'])) {
                    $booked++;
                }
            }

            $currentPatients = $occupied + count($nurseStation);

            $summary[] = [
                'ward' => $wardName,
                'today' => $todayCount,
                'tomorrow' => $tomorrowCount,
                'next3to7' => $next3to7Count,
                'total' => $totalBeds,
                'occupied' => $occupied,
                'booked' => $booked,
                'unavailable' => $unavailable,
                'currentpatients' => $currentPatients,
            ];
        }

        $summary = collect($summary)->sortBy('ward')->values()->toArray();
        // dd($summary);

        $totalOccupied = 0;
        $totalBeds = 0;
        $disciplineOccupied = [];
        $groupedDisciplineOccupied = [];

        foreach ($content["WardList"] as $ward) {
            $bedList = $ward['BedList'] ?? [];

            foreach ($bedList as $bed) {
                $totalBeds++;

                if (!empty($bed['episodeno'])) {
                    $totalOccupied++;

                    $discipline = $bed['discipline'] ?? 'Unknown';
                    $disciplineOccupied[$discipline] = ($disciplineOccupied[$discipline] ?? 0) + 1;

                    // Grouping
                    if (str_contains($discipline, 'Cardiology')) {
                        $groupedDisciplineOccupied['Cardiology'] = ($groupedDisciplineOccupied['Cardiology'] ?? 0) + 1;
                    } elseif (str_contains($discipline, 'C/Thoracic')) {
                        $groupedDisciplineOccupied['Cardiothoracic'] = ($groupedDisciplineOccupied['Cardiothoracic'] ?? 0) + 1;
                    }
                }
            }
        }

        // 1. Hospital occupancy (total occupied / total beds)
        $results = [];
        $results['Hospital'] = number_format(($totalOccupied / $totalBeds) * 100, 2) . '%';

        // 2. Each discipline as % of total beds
        foreach ($disciplineOccupied as $name => $count) {
            $percentage = ($count / $totalBeds) * 100;
            $results[$name] = number_format($percentage, 2) . '%';
        }

        // 3. Grouped (Cardiology / Cardiothoracic) as % of total beds
        foreach ($groupedDisciplineOccupied as $group => $count) {
            $percentage = ($count / $totalBeds) * 100;
            $results[$group] = number_format($percentage, 2) . '%';
        }

        return view('dashboard.index', compact('summary', 'results'));

    }
}
