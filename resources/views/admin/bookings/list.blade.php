@extends('layouts.admin')

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link ref='stylesheet' href='{{ asset("admin/app-assets/css/jquery.fancybox.min.css") }}' />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <!-- END: Vendor CSS-->
    <link ref='stylesheet' href='{{ asset("admin/app-assets/css/select2.min.css") }}' />

@endSection()

@section('content')
    <!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Booking Table</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("bookings.ad-new-booking") }}' class='btn btn-info'>
                <i class='fas fa-plus'></i>
                Create New Booking
            </a>
          </p>
            @if($bookings && $bookings != null)
                <div >
                    <table class="table table-striped table-bordered complex-headers" id="booking_table">
                    <thead>
                        <tr>
                        <th rowspan="2" class="align-center">Room</th>
                        <th colspan="2" class="text-center bg-dark text-white">Guest Information</th>
                        <th colspan="2" class='text-center  bg-dark text-white'>Usage Information</th>
                        <th rowspan="2" class='bg-success'>Action</th>
                        </tr>
                        <tr class=''>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Check In Date</th>
                        <th>Room Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($bookings as $booking)
                              @php 
                                $user_detail = $booking->userdetail;
                                //$user_date = Carbon\Carbon::createFromFormat("Y-m-d h:i A",$booking->check_in_date);
                                //  $today = Carbon\Carbon::createFromFormat("Y-m-d",date("Y-m-d"));
                              @endphp
                              @if($user_detail):
                                <tr>
                                  <td>
                                    @php 
                                      $room_connector = $booking->room;
                                      echo "<strong>Room Number : </strong>".$room_connector->room_number;
                                      echo "<br />";
                                      echo "<strong>Block / Name :</strong> " . $room_connector->room_name; 
                                    @endphp
                                  </td>
                                  <td>
                                    @if($user_detail)
                                    <a href="{{route('users.view-user-detail',$user_detail->id)}}">
                                    {{ $user_detail->full_name() }}
                                    </a>
                                    @else
                                      User N/A
                                    @endif
                                    <br />
                                    @if($booking->is_occupied)
                                    <small class='text-muted'>
                                      (
                                      <a data-toggle="modal"
                                      data-target="#booking_modal"
                                      href="{{ route('modals.display',['reference'=>'Booking','reference_id'=>$booking->id,'modal'=>'assign_sewa_to_user','user_detail_id'=>$booking->user_detail_id]) }}">
                                        Assign Sewa
                                      </a>
                                      )
                                    </small>
                                    @endif
                                  </td>
                                
                                  <td>
                                    {{ $user_detail->phone_number ?? "User N/A" }}
                                  </td>
                                  <td>
                                    Date : {{ date("M, d Y",strtotime($booking->check_in_date)) }}
                                  </td>
                                  <td>
                                    {{ ucwords($booking->status) }}
                                  </td>
                                  <td>

                                    @if($booking->is_occupied)
                                    <a data-toggle="modal"
                                      data-target="#booking_modal"
                                      href="{{ route('modals.display',['reference'=>'Booking','reference_id'=>$booking->id,'modal'=>'check_out_logged_visitor']) }}">
                                      Clear Room 
                                      </a>
                                    @endif
                                    
                                    @if($booking->is_reserved)
                                      <a data-toggle="modal"
                                      data-target="#booking_modal"
                                      href="{{ route('modals.display',['reference'=>'Booking','reference_id'=>$booking->id,'modal'=>'cancel_reservation_policy']) }}">
                                        Reserve Option
                                      </a>
                                    @endif
                                  </td>
                                </tr>
                              @endif
                            @endforeach  
                        </tbody>
                    <tfoot>
                        <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Office</th>
                        <th>Extn.</th>
                        <th>E-mail</th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            @else
                <div class='text-center'>
                        <h4>No active Booking</h4>
                </div>
            @endif
      </div>
    </div>
  </div>
  

  <!-- start modal -->
    <div class="modal fade text-left" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel1">Booking Update</h3>
            <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
              <i class="bx bx-x"></i>
            </button>
          </div>
          <div class='modal-body'>
            <div id="modal-content-fetch">Loading Form, Please wait...</div>
          </div>
        </div>
      </div>
    </div>

        <!-- / end modal -->

</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
    @if($bookings)
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
                $("#booking_table").DataTable();

                $('#booking_modal').on('shown.bs.modal', function (event) {
                  $.ajax({
                      method : "GET",
                      url : event.relatedTarget.href,
                      success: function (response){
                          $("#modal-content-fetch").html(response);
                      }
                  });
                })
            });
        </script>
    @endif
@endSection()