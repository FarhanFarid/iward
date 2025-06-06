@extends('layouts.master')

@section('content')

<div class="row mb-3 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important; background-color: #F8F8FF;">
            <div class="row">
                <div class="col-md-12" style="display:flex; align-items: center; justify-content: center;">
                    <h1 style="text-align: center; justify-content: center;">WELCOME TO IJN E-WARD DASHBOARD</h1>
                </div>
            </div>
        </div>
        <br/>
    </div>
</div>

<div class="row mt-5 mb-3 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important; background-color: #F8F8FF;">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #fff0f8;">
                        <div class="row m-3">
                            <div class="col-md-12">
                                <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: black;">
                                    SUMMARY (
                                    @php
                                        $summaryList = [];
                                        foreach ($results as $label => $value) {
                                            $summaryList[] = "$label: $value";
                                        }
                                        echo implode(', &nbsp', $summaryList);
                                    @endphp
                                    )
                                </h4>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="bedmanagement-table" style="width: 100% !important;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Ward')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Today')}}</th>
                                    <th style="color: #DB7093; min-width: 200px; text-align: center;  vertical-align: middle;">{{__('Tommorow')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('3-7 Days')}}</th>
                                    <th style="color: #DB7093; min-width: 200px; text-align: center;  vertical-align: middle;">{{__('Total')}}</th>
                                    <th style="color: #DB7093; min-width: 150px; text-align: center;  vertical-align: middle;">{{__('Occupied')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Booked')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Unavailable')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Current')}}</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 600;">
                                @foreach ($summary as $row)
                                    <tr>
                                        <td>{{ $row['ward'] }}</td>
                                        <td>{{ $row['today'] }}</td>
                                        <td>{{ $row['tomorrow'] }}</td>
                                        <td>{{ $row['next3to7'] }}</td>
                                        <td>{{ $row['total'] }}</td>
                                        <td>{{ $row['occupied'] }}</td>
                                        <td>{{ $row['booked'] }}</td>
                                        <td>{{ $row['unavailable'] }}</td>
                                        <td>{{ $row['currentpatients'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
</div>


@endsection