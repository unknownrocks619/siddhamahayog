
@if( ! $filter_session->count() )
        <div class='col-md-8'>
            <h4 class='text-danger'>Record not Found</h4>
        </div>
@endif

@if ($filter_session->count())
    <table class="table table-striped table-hover table-bordered complex-headers" id="user_table">
        <thead>
            <tr class=''>
                <th>Name</th>
                <th>Phone</th>
                @foreach ($filter_session as $session)
                    <th>
                        {{ date("M d",strtotime($session->start_time)) }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($all_event_user as $users)
                <tr>
                    <td> {{ $users->userDetail->full_name() ?? "User N/A" }} </td>
                    <td> {{ $users->userDetail->phone_number }} </td>
                    @foreach ($filter_session as $session)
                        @php
                            $user_attendance = \App\Models\EventVideoAttendance::where('user_id',$users->user_detail_id)
                                                    ->where('video_class_log',$session->id)
                                                    ->first();
                            
                        @endphp
                        @if ($user_attendance)
                            <td class='bg-success text-white m-2 border'>
                                Present
                            </td>
                        @else
                            <td class='bg-danger text-white m-2 border'>
                                Absent
                            </td>
                        @endif 
                    @endforeach
                </tr> 
            @endforeach
        </tbody>

        <tfoot>
            {{ $filter_session->paginate() }}
        </tfoot>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#user_table").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]

            });
        });
    </script>
@endif