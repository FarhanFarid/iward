<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #FAEBD7; border: solid; border-color: #ffffff; width: 100%; height: 200px; display: flex; flex-direction: column;">
    <!-- Title -->
    <div class="text-center mt-2">
        <h3 style="color: #000000;"><b>Staff Assigment</b></h3>
        <hr style="width: 50%; color: #333333; margin: auto; height: 3px; border: none; background-color: #333333;">
    </div>

    <!-- Table Container -->
    <div class="mt-2" style="overflow-y: auto; flex: 1; padding: 0 10px;">
        <table class="table table-sm m-0" style="width: 100%; table-layout: fixed; font-size: 1.2rem;">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    <th style="width: 10%; padding: 2px;">Role</th>
                    <th style="width: 30%; padding: 2px;" class="text-center">AM</th>
                    <th style="width: 30%; padding: 2px;" class="text-center">PM</th>
                    <th style="width: 30%; padding: 2px;" class="text-center">On Call</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 2px;"><b>Team Leader</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['tlam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['tlpm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['tloncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Incharge</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['iam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['ipm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['ioncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Medication</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['medam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['medpm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['medoncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Runner</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['runam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['runpm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['runoncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Obs. Nurse</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['obsam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['obspm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolessa['obsoncall'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
