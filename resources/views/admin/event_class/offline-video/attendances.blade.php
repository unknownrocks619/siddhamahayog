@extends("layouts.admin")
@section("content")
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Offline Video Watch List</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("events.admin_offline_video_list") }}' class='btn btn-info'>Back To List</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Full Name </th>
                  <th>Total Watch</th>
                  <th>Watch Time</th>
                  <th>Watch End</th>
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
                                {{ $attend->total_watch }}
                            </td>
                            <td> {{ $attend->start_time }} </td>
                            <td> {{ $attend->end_time }} </td>
                            <td>
                                <span class='badge badge-success'>Present</span>
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