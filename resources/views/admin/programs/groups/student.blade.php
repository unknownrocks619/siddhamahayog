<table>
    <thead>
    <tr>
        <th colspan="7" style="font-size: 30px;">{{$program->program_name}} Student List</th>
    </tr>
    <tr></tr>
    <tr>
        <th>Total JAP Count</th>
        <th>Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Gotra</th>
        <th>Country</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $record)
        <tr>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->total_counter}}</td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->full_name}}</td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->phone_number ?? 'N/A'}}</td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->email ?? 'N/A'}}</td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->gotra}}</td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">
                @php
                    if ( ! $record->member_country &&  ! $record->country_name) {
                            echo 'N/A';
                    } else if ($record->member_country && ! (int) $record->member_country) {
                        echo $record->member_country;
                    } else {
                        echo $record->country_name;
                    }

                @endphp
            </td>
            <td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000">
                @php
                    if ( ! $record->address) {
                            echo 'N/A';
                    }else {

                        $addressDecode = json_decode($record->address);
                        if ( isset($addressDecode->street_address) ) {
                            echo $addressDecode->street_address;
                        } else if ( $record->personal_detail ) {
                            $detailDecode = json_decode($record->personal_detail);
                            if (isset($detailDecode->street_address) ) {
                                echo $detailDecode->street_address;
                            }
                        } else {
                            echo 'N/A';
                        }

                    }
                @endphp
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
