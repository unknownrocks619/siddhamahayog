@extends('layouts.admin')

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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
            <a href='{{ route("bookings.booking-list") }}' class='btn btn-info'>
                <i class='fas fa-plus'></i>
                Go Back 
            </a>
          </p>
      </div>
      <div class='card-body'>
        <!-- Booking Forms -->
        <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
            @if(Session::has("success"))
                <div class='alert alert-success'>
                    {{ Session::get("success") }}
                </div>
            @endif
            <!-- users edit account form start -->
                    <form method="POST" action="{{ route('bookings.ad-store-booking') }}" class="form-validate">
                        @csrf
                        <input type='hidden' name='source' value='admin' />
                        <div class="row bg-warning">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Select Visitor
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        @isset($user_detail)
                                            <input type="hidden" name="visitor" value='{{ $user_detail->id }}' />
                                            <input type="text" class='form-control' readonly value="{{ $user_detail->full_name() }}" />
                                        @endisset
                                        @empty($user_detail)
                                            <select name='visitor' class='form-control select2_user_list'></select>
                                        @endempty
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-6 col-sm-6'>
                                <div class="form-group">
                                    <label class='control-label'>
                                        Room Number
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    <select required class='form-control room_selection' name="room_number">
                                        <option value='-1'></option>
                                        @php
                                            $rooms = new \App\Models\Room;
                                            foreach ($rooms->all() as $room){
                                                echo "<option value='$room->id'>{$room->room_number} - {$room->room_name} </option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6" style="display:none" id='room_description_container'>
                                <div class="form-group">
                                    <label class='control-label'>
                                        Room Information
                                    </label>
                                    <p id='room_description_text'>Room Detail Goes here</p>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-6 col-sm-12' @empty($user_detail) style="display:none" @endempty id='card_container'>
                                <div id='card' class='card' >
                                    @isset($user_detail)
                                    <div class='card-body text-center'>
                                        @if($user_detail->user_profile)
                                            <img id='parent_image_id' src="{{ asset ($user_detail->user_profile->image_url) }}" class="card-img-top" style="width:12rem" />
                                        @else
                                            <img id="parent_image_id" src="{{ asset ('thumbs/blank.png') }}" class='card-img-top' style="width:12rem" />
                                        @endif
                                        <p ><button type='button' onclick='newCapture()' class='btn btn-link'>[Capture New Image]</button></p>
                                        <h5 class="card-title text-center">{{ $user_detail->full_name() }}</h5>
                                        <p class='card-text text-left' id="text">
                                            Phone Number : {{ $user_detail->phone_number }}
                                            <br />
                                            Address : {{ $user_detail->address() }}
                                            <br />
                                            User Type : {{ $user_detail->user_type }}
                                        </p>    
                                    </div>
                                    @endisset
                                </div>
                            </div>
                            <div class='col-md-6 col-sm-12'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <label class='label-control'>Check In Date
                                            <span class="text-danger required">*</span>
                                        </label>
                                        <input type="date" name="check_in_date" value="{{ old('check_in_date',date('Y-m-d')) }}" class='form-control' required />
                                        <span class='text-muted'>To Reserve in advance just choose date For Future.</span>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class='label-control'>Select Visit Time</label>
                                        <input type="text" name="check_in_time" value="{{ old('check_in_time',date('h:i A')) }}" class="form-control" required />
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class='label-control'>Remark</label>
                                        <textarea name="remarks" class='form-control'>{{ old('remarks') }}</textarea>
                                    </div>

                                </div>  
                            </div>

                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-4'>
                                <button type="submit" class='btn btn-primary btn-block'>Save Visitor Log</button>
                            </div>
                        </div>
                    </form> 
                    <!-- users edit account form ends -->
                </div>
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2_user_list").select2({
      placeholder: 'Search User by Name or Phone number...',
      ajax : {
              url : '{{ url(route("get_user_list")) }}',
              dataType : 'json',
              processResults : function (data)
              {
                  // params.page = params.page || 1;
                  return {
                      results : data.results
                    
                  };
              }
          }
      });

      $(".select2_user_list").change(function(){
          var user_detail = $(this).val();
        $.ajax({
            method : "GET",
            url : "{{ route('modals.display') }}?modal=display_user_detail_booking&user_detail_id="+user_detail,
            success: function (response){
                $("#card_container").fadeIn('slow',function(){
                    $("#card").html(response);
                })
            }
        });
      });
      $(".room_selection").select2({
            placeholder : {
                id:'-1',
                text : "Select Room..."
             },
            allowClear: true
      });

      $(".room_selection").change(function(){
          var selectedRoom = $(this).val();
        //   console.log(selectedRoom);
          $.get( "{{  route('rooms.check-avaibility') }}?room_number="+selectedRoom, function(data){
            if (data.available === "Available"){
                console.log(data.available);
                var text_construction = "<span>";
                    text_construction += "Room number: " + data.room_number;
                    text_construction += "<br />";
                    text_construction += "Room Name / Block : " + data.room_name;
                    text_construction += "<br />";
                    text_construction += "Room Capacity : " + data.room_capacity;
                    text_construction += "<br />";
                    text_construction += "<span class='text-success'>Available Space : " + data.available_room + "</span>   ";
                    text_construction += "</span>";
                    
            } else if (data.available === "Not Available" && data.success === true) {
                var text_construction = "<span>";
                    text_construction += "Room number: " + data.room_number;
                    text_construction += "<br />";
                    text_construction += "Room Name / Block : " + data.room_name;
                    text_construction += "<br />";
                    text_construction += "Room Capacity : " + data.room_capacity;
                    text_construction += "<br />";
                    text_construction += "<span class='text-danger'>Available Space : " + data.available_room + "</span>";
                    text_construction += "<br />";
                    text_construction += "Total Occupied : " + data.occupied_room;  
                    text_construction += "</span>";
            } else {
                var text_construction = "<span class='text-danger'>";
                    text_construction += data.message;
                    text_construction += "</span>";
            }
            $("#room_description_container").fadeIn('medium',function(){
                $("#room_description_text").html(text_construction);
            })
          });
      })
    })
    </script>

    @isset($user_detail)
    <script>
        var newCapture = function () {
            window.open("{{ route('modals.display') }}?modal=user_webcam_display&user_detail_id={{ $user_detail->id }}",'Visitors Photo','width=800,height=450,resizable=no');    
        }

        newCapture.onunload = function(){ console.log('Child window closed'); };


                // webCampWindow = window.open("{{ route('modals.display') }}?modal=user_webcam_display&user_detail_id={{ $user_detail->id }}",'Visitors Photo','width=800,height=450,resizable=no');
        </script>
    @endisset
@endSection()