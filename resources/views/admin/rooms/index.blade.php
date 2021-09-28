@extends('layouts.admin')

@section('page_css')

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">

@endSection()

@section('content')
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Rooms</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <!-- <a href='#' id="onshown" class='btn btn-primary' data-toggle='modal' data-target="#default">Create New Sewa</a> -->
            <a href="{{ route('rooms.add-room') }}" id="onshowbtn" class='btn btn-primary'>
              <span class='ficon  bx bx-plus-medical'>
                Add New Room
              </span>
            </a>           
          </p>
          <div class="table-responsive" id='room_data'>
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th rowspan="2" class="align-center">Room Number</th>
                  <th rowspan='2' class="text-center">Block / Name</th>
                  <th colspan="2" class='text-center  bg-dark text-white'>Engagement</th>
                  <th rowspan="2" class=''>Action</th>
                </tr>
                <tr class=''>
                  <th>Total Capacity</th>
                  <th>Occupied</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rooms as $room) 
                  <tr>
                    <td>{{ $room->room_number }}</td>
                    <td>
                      {{ $room->room_name }}
                      @if($room->room_description)
                        <br />
                        <small class='text-muted'>{{ $room->room_description }}</small>
                      @endif

                      @if($room->room_owner_id) 
                        <br />
                        <small class='text-muted'>Room Contributor: 
                          <a href="{{ route('users.view-user-detail',$room->room_owner_id) }}">
                          {{ $room->userdetail->full_name() }}
                          </a>
                        </small>
                      @endif
                    </td>
                    <td>
                      Capacity : {{ $room->room_capacity ?? "OPEN" }}
                      @php 
                        $occupied_room = $room->occupied_room->count();
                        if ($occupied_room && $room->room_capacity){
                          $total_occupied = $occupied_room;
                          $total_available = $room->room_capacity - $total_occupied;

                          echo "<br />";
                          echo "Available : " ;
                            if($total_available < 1 ) {
                              echo "<span class='text-danger'>";
                                echo $total_available;
                              echo "</span>";
                            } else {
                              echo "<span class='text-success'>";
                                echo $total_available;
                              echo "</span>";
                            }
                        }
                      @endphp
                    </td>
                    <td>
                        @php 
                          if ($occupied_room && isset($total_occupied)) {
                            echo $total_occupied . " Occupied ";
                          } else {
                            echo "Unoccupied";
                          }
                        @endphp
                    </td>
                    <td>
                      <a href="{{ route('rooms.update-room',$room->id) }}" class='text-primary'>
                      Edit
                      </a> | 
                      <a href="{{ route('modals.display',['modal'=>'room_delete_confirmation_modal','reference'=>'Room','reference_id'=>$room->id]) }}" data-option="{{ $room->id }}" data-toggle="modal" data-target="#delete" class='text-danger'>Delete</a>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        <!-- Delete Modal -->
          <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header ">
                  <h3 class="modal-title" id="myModalLabel1">Confirm Delete</h3>
                  <button type="button" class="close rounded-pill bg-success text-white" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                  </button>
                </div>
                <div class='modal-body'>
                  <div id="delete-modal-content">Loading Form, Please wait...</div>
                </div>
              </div>
            </div>
          </div>
        <!-- / Delete Modal -->
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
    <!-- BEGIN: Page JS-->
    <script>
      $(document).ready(function(){
        $('#delete').on('shown.bs.modal', function (event) {
          $.ajax({
                method : "GET",
                url : event.relatedTarget.href,
                success: function (response){
                    $("#delete-modal-content").html(response);
                }
            });
        })
        
      });

    </script>
@endSection()