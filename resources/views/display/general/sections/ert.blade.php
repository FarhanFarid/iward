<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #FAF0E6; border: solid; border-color: #ffffff; width: 100%; height: 200px; display: flex; flex-direction: column;">
    <!-- Title -->
    <div class="text-center mt-2">
        <h3 style="color: #000000;"><b>Emergency Response Team</b></h3>
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
                    <td style="padding: 2px;"><b>Incident Officer</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['ioam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['iopm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['iooncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Fire Warden</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fwam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fwpm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fwoncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Fire Squad</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fsam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fspm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['fsoncall'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px;"><b>Rescue Squad</b></td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['rsam'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['rspm'] }}</td>
                    <td class="text-center text-truncate" style="padding: 2px;">{{ $rolesert['rsoncall'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
