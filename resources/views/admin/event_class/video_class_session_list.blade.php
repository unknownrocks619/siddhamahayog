@extends("layouts.admin")

@section('content')
    <!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">`{{ $event->sibir_title }}` All Session</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("events.admin_video_class_list") }}' class='btn btn-info'>Back To List</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Session Date </th>
                  <th class="align-center">Status</th>
                  <th  class="text-center bg-dark text-white"> Start Time</th>
                  <th class='text-center  bg-dark text-white'>End Time</th>
                  <th class='text-center '>Total Present</th>
                </tr>
              </thead>
                <tbody>
                    @foreach ($all_video_logs as $active_session)
                        <tr>
                            <td>
                                {{ date("M,d Y",strtotime($active_session->start_time)) }}
                            </td>
                            <td>
                                    @if($active_session->active)
                                        <span class='badge badge-success'>Active</span>
                                    @else
                                    <span class='badge badge-info'>Closed</span>
                                    @endif

                            </td>
                            <td>
                                {{ date("h:i A",strtotime($active_session->start_time)) }}
                            </td>
                            <td>
                                {{ date("h:i A",strtotime($active_session->end_time)) }}
                            </td>
                            <td>
                                @if($active_session->attendee_count) 
                                    {{ $active_session->attendee_count }}
                                    <span class='px-1'>
                                    <a href="{{ route('events.admin_view_session_attendance',$active_session->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19c-4.182 0-7.764-4.013-9.257-5.962a1.692 1.692 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5c4.182 0 7.764 4.013 9.257 5.962z" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                                    </a>
                                    </span>
                                @else
                                {{ $active_session->attendee_count }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endsection