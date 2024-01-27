<table>
    <thead>
        <tr>
            <th colspan="7" style="font-size: 30px;">{{$program->program_name}} Grouping for Single Entries</th>
        </tr>
        <tr></tr>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Gotra</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $record)
            <tr>
                <td>{{$record->full_name}}</td>
                <td>{{$record->email}}</td>
                <td>{{$record->phone_number}}</td>
                <td>{{$record->gotra}}</td>
                <td>{{ucwords($record->gender)}}</td>
                <td>{{$record->country_name}}</td>
                <td>
                    @php
                        $address = json_decode($record->address);
                    @endphp

                    {{$address?->street_address}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
