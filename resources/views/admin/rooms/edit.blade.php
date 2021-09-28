@extends('layouts.admin')

@section('page_css')

    <!-- BEGIN: Page CSS-->
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
          <h4 class="card-title">Rooms</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <!-- <a href='#' id="onshown" class='btn btn-primary' data-toggle='modal' data-target="#default">Create New Sewa</a> -->
            <a href="{{ route('rooms.room-list') }}" class='btn btn-primary'>
                Go Back
            </a>           
          </p>

        <!-- Room Frm -->
        <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit account form start -->
                    <form method="POST" action="{{ route('rooms.update-room',$room->id) }}" class="form-validate">
                        @method("PUT")
                        @csrf
                        <input type='hidden' name='source' value='admin' />
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Room Number
                                            <span class='required text-danger'>*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Room Number *"
                                            value="{{ old('room_number',$room->room_number) }}"
                                            name="room_number" readonly required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Block / Name
                                        </label>
                                        <input type="text" class="form-control" placeholder="Block / Room Name"
                                            value="{{ old('room_name',$room->room_name) }}"
                                            name="room_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>
                                            Additional Remarks
                                        </label>
                                        <textarea name='room_description' class='form-control'>{{ old('room_description',$room->room_description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Total Capacity
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Room Capacity"
                                            value="{{ old('room_capacity',$room->room_capacity) }}"
                                            name="room_capacity" />
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Room Type
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <select name="room_type" class="form-control">
                                        <option value="hall" @if(old('room_type',$room->room_type) == "hall") selected @endif>Hall</option>
                                        <option value="deluxe" @if(old('room_type',$room->room_type) == "deluxe") selected @endif>Deluxe</option>
                                        <option value="single" @if(old('room_type',$room->room_type) == "single") selected @endif>Single</option>
                                        <option value="other" @if(old('room_type',$room->room_type) == "other") selected @endif>Other</option>
                                    </select>
                                </div>  
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Room Location
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <input type="text" class='form-control' name="room_location" value="{{ old('room_location',$room->room_location) }}" />
                                </div>  
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class='control-label'>
                                        Room Category
                                        <span class='text-danger required'>*</span>
                                    </label>
                                    <select name="room_category" class="form-control">
                                        <option value="VIP"  @if(old('room_category',$room->room_category) == "hall") selected @endif>VIP</option>
                                        <option value="Regular"  @if(old('room_category',$room->room_category) == "Regular") selected @endif>Regular</option>
                                        <option value="Standard"  @if(old('room_category',$room->room_category) == "Standard") selected @endif>Standard</option>
                                        <option value="Other"  @if(old('room_category',$room->room_category) == "Other") selected @endif>Other</option>
                                    </select>
                                </div>  
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-10 col-sm-12'>
                                <div class="form-group">
                                    <label class='control-label'>
                                        Select Room Contributor
                                        <span class='required text-danger'>*</span>
                                    </label>
                                    @if($room->room_owner_id)
                                    <input type='text' readonly value="{{ $room->userdetail->full_name() }}" class='form-control' />
                                    @else
                                    <select name="room_owner_id" class='form-control select_room_owner'></select>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class='row'>
                            <div class='col-md-12 text-right'>
                                <button type="submit" class='btn btn-primary'>Update Room Information</button>
                            </div>
                        </div>
                    </form>
                    <!-- users edit account form ends -->
                </div>
        <!-- / Room Frm -->

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
        $(".select_room_owner").select2({
        placeholder: 'Type name or Phone Number',
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
    })
</script>
@endSection()