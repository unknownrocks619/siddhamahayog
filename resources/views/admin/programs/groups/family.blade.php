<table>
    <thead>
    <tr>
        <th colspan="7" style="font-size: 30px;">{{$program->program_name}} Grouping for Single Entries</th>
    </tr>
    <tr></tr>
    <tr>
        <th>Total Family Member</th>
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
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->total_family_member}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->full_name}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->email}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->phone_number}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->gotra}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{ucwords($record->gender)}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">{{$record->country_name}}</td>
            <td style="color: #EC3A3B;border-top: 1px solid #000000;border-bottom: 1px solid #000000">
                @php
                    $address = json_decode($record->address);
                @endphp

                {{$address?->street_address}}
            </td>

        </tr>
        @php
            $explodeFamilyMembers = explode(',',$record->family_members);
            $explodeFamilyMemberPhone = explode(",",$record->family_contact_number);
            $explodeFamilyGender = explode(',',$record->family_gender);
            $explodeFamilyRelation = explode(',',$record->family_relation);
        @endphp
        <tr>
            <th style="color:#ffffff;background: #cfd2d6;">Full name</th>
            <th style="color:#ffffff;background: #cfd2d6">Gender</th>
            <th  style="color:#ffffff;background: #cfd2d6">Contact Number</th>
            <th  style="color:#ffffff;background: #cfd2d6">Relation</th>
        </tr>
        @foreach($explodeFamilyMembers as $index => $familyMember)
            <tr>
                <td style="border-bottom: 2px solid #000000">{{$familyMember}}</td>
                <td style="border-bottom: 2px solid #000000">
                    @isset($explodeFamilyGender[$index]) {{$explodeFamilyGender[$index]}} @endisset
                </td>
                <td style="border-bottom: 2px solid #000000">
                    @isset($explodeFamilyMemberPhone[$index]) {{$explodeFamilyMemberPhone[$index]}} @endisset
                </td>
                <td style="border-bottom: 2px solid #000000">
                    @isset($explodeFamilyRelation[$index]) {{$explodeFamilyRelation[$index]}} @endisset
                </td>
            </tr>
        @endforeach
        <tr style="background: #EC3A3B"></tr>
    @endforeach
    </tbody>
</table>
