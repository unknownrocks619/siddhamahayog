<table border='1' width="100%">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php
            // $meeting_id = "89386129179";
            $meeting_id = "82879809452";
            $current_sibir_record = 23;
            // get all users with list
            $registered_user = \App\Models\UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                    ->where('sibir_record_id',$current_sibir_record)
                                    ->get();
        @endphp
        <a href="{{ route('admin_generate_link',[$meeting_id,$current_sibir_record]) }}">Generate For All</a>
        @foreach ($registered_user as $user_with_link)
            <tr>
                <td>{{ $user_with_link->userDetail->full_name() }}</td>
                <td> 
                    @php
                        $user_link = \App\Models\SadhakUniqueZoomRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                        ->where('meeting_id',$meeting_id)
                                        ->first();
                        if ( ! $user_link ) {
                            echo "Not Generated";
                        } else {
                            echo "generated";
                        }
                    @endphp
                </td>
                <td>
                    <a href="{{ route('admin_generate_link',[$meeting_id, $user_with_link->sibir_record_id,auth()->user()->user_detail_id]) }}">
                    Generate
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>