@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Available Videos</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("events.admin_offline_video_add") }}' class='btn btn-info'>Upload Offline Video</a>
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Event / Class Name </th>
                  <th class='text-center bg-dark text-white'>Status</th>
                  <th class='text-center bg-dark text-white'>Uploaded Date</th>
                  <th>Total View</th>
                  <th class='bg-success'>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($offline_video as $video)
                    <tr>
                      <td>
                          {{ $video->event_source->sibir_title }}
                      </td>
                      <td>
                          <a href="{{ route('events.admin_update_only_offline_video_status',$video->id) }}">
                          @if($video->is_active)
                            <span class='badge bg-success'>Active</span>
                          @else
                            <span class='badge bg-danger'>Inactive</span>
                          @endif
                          </a>
                      </td>
                      <td>
                        {{ date("Y-m-d h:i A",strtotime($video->created_date)) }}
                      </td>
                      <td>
                          @if($video->video_attendance_count)
                            {{ $video->video_attendance_count }}
                            <a href="{{ route('events.admin_offline_video_attendance_list',$video->id) }}">List</a>
                          @else
                            {{ $video->video_attendance_count }}
                          @endif
                      </td>
                      <td>
                          <a href="{{ $video->full_link }}" target="__blank">View</a>
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