@extends("layouts.admin")
@section('page_css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <!-- END: Vendor CSS-->

@endSection()

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
            <a href='{{ route("events.admin_view_active_session",$event_class->event_id) }}' class='btn btn-info'>Back To List</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers" id="attendance_table">
              <thead>
                <tr>
                  <th class="align-center">Full Name </th>
                  <th>Phone Number</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th class='text-center  bg-dark text-white'>Attendance</th>
                  <th></th>
                </tr>
              </thead>
              @php
                $all_subscribers = \App\Models\UserSadhakRegistration::with(['userDetail'])->where('sibir_record_id',$event_class->event_id)->get();
              @endphp

                @foreach ($all_subscribers as $student)
                  @if ($student->userDetail)
                  <tr>
                      <td>
                          {{ $student->userDetail->full_name() }}
                      </td>
                      <td>
                        {{ $student->userDetail->phone_number }}
                      </td>
                      <td>
                        {{ $student->userDetail->userlogin->email }}
                      </td>
                      <td>
                        @if ((int) $student->userDetail->country && (int) $student->userDetail->city)
                          {{ address([$student->userDetail->country,$student->userDetail->city]) }}
                        @else
                          {{ $student->userDetail->country }}
                        @endif
                      </td>
                      <td>
                          @php
                            $attendace_ = \App\Models\EventVideoAttendance::where('video_class_log',$log_id->id)
                                                                            ->where('user_id',$student->userDetail->id)
                                                                            ->first();
                          @endphp
                            @if($attendace_)
                            <span class='badge badge-success'>Present</span>
                            @else
                              <span class='badge badge-danger bg-danger'>Absent</span>
                            @endif
                      </td>
                      <td>
                          @if($attendace_)
                          {{ date("Y-m, D H:i A",strtotime($attendace_->created_at)) }}
                          @else
                            N/A                            
                          @endif
                      </td>
                  </tr>
                  @endif
                @endforeach
            </table>
          </div>
        
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endsection


@section('page_js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
        <!-- END: Page Vendor JS-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#attendance_table").DataTable({
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
@endSection()