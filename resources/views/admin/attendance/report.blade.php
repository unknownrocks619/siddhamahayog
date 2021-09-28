<table border='1'>
    <thead>
        @php
        
            $event = \App\Models\SibirRecord::findOrFail(23);
            // let fetch sessions
            $event_class_setup = \App\Models\EventVideoClass::where('event_id',$event->id)->first();
            $all_session = \App\Models\VideoClassLog::where('event_video_class_id',$event_class_setup->id)->get();
        @endphp
       
    </thead>
    <tbody>

        @php
            $all_event_users = \App\Models\UserSadhakRegistration::where("sibir_record_id",$event->id)->get();

        @endphp
        <tr>
            <th></th>
            @foreach ($all_session as $session)
                <th> {{ date("Y-m-d",strtotime($session->start_time)) }} </th> 
            @endforeach
        </tr>
        @foreach ($all_event_users as $event_users_list)
            <tr>
                <td> {{ $event_users_list->userDetail->full_name() }}</td>
                @foreach ($all_session as $session)
                    @php
                        $u_at = \App\Models\EventVideoAttendance::where('user_id',$event_users_list->userDetail->id)
                                                    ->where('video_class_log',$session->id)
                                                    ->first();
                        if ($u_at){
                            echo "<td>";
                                    echo "P";
                            echo "</td>";
                        } else {
                            echo "<td>";
                                echo "A";
                            echo "</td>";
                        }
                    @endphp
                    
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>