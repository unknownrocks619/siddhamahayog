@extends("layouts.admin")
@section("content")
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Active Class Attendance</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("events.admin_video_class_list") }}' class='btn btn-info'>Back To List</a>

           
          </p>
          <div class="table-responsive">
            <x-alert></x-alert>
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Full Name </th>
                  <th  class="text-center bg-dark text-white">Join Time</th>
                  <th  class="text-center bg-dark text-white">Left Time</th>
                  <th class='text-center  bg-dark text-white'>Attendance</th>
                </tr>
              </thead>
              <tbody>
                    @foreach ($attendances as $attend)
                        <tr>
                            <td>
                                @php
                                    $user_detail = \App\Models\userDetail::find($attend->user_id);
                                    if ( ! $user_detail)  {
                                        echo " ERR ";
                                    } else {
                                        echo $user_detail->full_name();
                                    }
                                @endphp
                            </td>
                            <td>
                                {{ date("Y-m, D H:i A",strtotime($attend->created_at)) }}
                            </td>
                            <td>
                              {{ date("Y-m, D H:i A",strtotime($attend->updated_at)) }}
                            </td>
                            <td>
                                <span class='badge badge-success'>Present</span>
                                <span class='badge bg-danger'><a class='text-white' href="{{ route('events.admin_revoke_class_attendance',['u_id'=>$user_detail->id,'event_id'=>$attend->event_class_id,'v_l_id'=>$attend->video_class_log]) }}">Revoke</span>
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