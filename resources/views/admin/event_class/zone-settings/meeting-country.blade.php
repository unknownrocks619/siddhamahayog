@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Available Classes</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("events.admin_video_add_form") }}' class='btn btn-info'>Add New Class</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Event / Class Name </th>
                  <th  class="text-center bg-dark text-white">Class Information</th>
                  <th class='text-center  bg-dark text-white'>Status</th>
                  <th class='text-center  bg-dark text-white'>Total Session</th>
                  <th class='bg-success'>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($all_class as $event )
                      <tr>
                        
                        <td>
                          <a href="{{ route('events.admin_view_active_session',$event->event_id) }}">
                            {{ $event->event_source->sibir_title }}
                          </a>
                        </td>
                        <td> Event Time {{ date("H:i A", strtotime($event->class_start)) }} </td>
                        <td> @if($event->is_active) <span class='label label-success'>Active</label> @else <span class='label label-danger'>Inacitve</span> @endif </td>
                        
                        <td>
                            <a href="{{ route('events.admin_view_active_session',$event->event_id) }}">
                            Total Session: {{ $event->total_session->count() }}
                            </a>
                            <br />
                            <a href="{{ route('events.admin_view_active_attendance',[$event->id]) }}">View Attendance</a>
                        </td>
                        <td>
                        @if($event->is_active) 
                        <form method="post" action="{{ route('events.admin_video_end') }}">
                            @csrf
                            <input type="hidden" name="class" value="{{ $event->id }}" />
                            <button type="submit" class='btn btn-danger'>End Session</button> 
                          </form>
                        @else 
                          <form target="_blank" method="post" action="{{ route('events.admin_video_start') }}">
                            @csrf
                            <input type="hidden" name="class" value="{{ $event->id }}" />
                            <button type="submit" class='btn btn-success'>Start Session</button> 
                          </form>
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

@section("footer_js")
@endsection