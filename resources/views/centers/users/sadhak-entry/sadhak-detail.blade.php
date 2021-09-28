@extends('layouts.center')

@section('page_css')

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ $user_detail->full_name() }} 
                        <span id='pet_name_container'>
                        @if($user_detail->pet_name)
                            ( {{ $user_detail->pet_name }} )
                        @endif
                        </span>
                    </h4>
                </div>
                @include("admin.users.sadhak-entry.partials.navigation")
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-8">
            <div class="card">

               
                <!-- Card flex-->

                <div class="card-header">
                    <h4 class="card-title">{{ __("Profile Detail") }}</h4>
                </div>
                <div class="card-body">
                    <div class='row'>
                        <div class='col-md-8 col-sm-12'>
                            <ul class="list-unstyled">
                                <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>
                                    @if(ctype_digit($user_detail->country) && ctype_digit($user_detail->city) )
                                        {{ address($user_detail->country,"country") }}, {{ address($user_detail->city,"city") }}
                                    @else
                                        
                                        {{ $user_detail->address() }}
                                    @endif
                                </li>
                                <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i>{{ $user_detail->phone_number }} </li>
                                <li><i class="cursor-pointer bx bx-time mb-1 mr-50"></i>July 10</li>
                                <li id='display_email_address'><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i>
                                    @php
                                        $user_login = $user_detail->userlogin;
                                    @endphp
                                    
                                    @if(isset ($user_login->email)) 
                                        {{ $user_login->email }} 
                                    @endif
                                </li>
                                <li id='display_email_address'>
                                    <i class="cursor-pointer bx bx-calendar mb-1 mr-50"></i>
                                    DOB: 
                                    {{  $user_detail->date_of_birth_nepali ?? $user_detail->date_of_birth_eng}}
                                </li>

                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            @if($user_detail->user_profile && $user_detail->user_profile->image_url)
                                <img src='{{ asset ($user_detail->user_profile->image_url) }}' class='img-thumbnail img-circle pl-0 ml-0' />
                                <span>[
                                        <a href="{{ route('users.view-service-detail',[$user_detail->id,'medias']) }}">
                                            View Media Profile
                                        </a>
                                    ]
                                </span>
                            @else
                            <img id="parent_image_id" src="{{ asset ('thumbs/blank.png') }}" class='card-img-top' style="width:12rem" />
                            <!-- <a href=''>
                            Upload Photo
                            </a> -->
                            <!-- |  -->
                            <a class='btn btn-block btn-info' data-toggle="modal" 
                                data-target="#display_modal"
                                 href='{{ route("modals.display",["modal"=>"user_webcam_display","user_detail_id"=>$user_detail->id]) }}'>
                            Open Camera
                            </a>
                            @endif
                        </div>
                    </div>
               
                    <div class="row" id="marital_status_info">
                        <div class="col-sm-6 col-12">
                            <h6><small class="text-muted">Gender</small></h6>
                            <p>
                                {{ ucwords($user_detail->gender) }}
                            </p>
                        </div>
                        <div class="col-sm-6 col-12">
                            <h6><small class="text-muted">Prefered Center</small></h6>
                            <p class='card-text text-primary'>
                                {{ $user_registration->branch->name }}
                            </p>
                        </div>
                        
                    </div>

                    <div class='row' id='donation'>
                        <div class="col-md-12">
                            <a data-toggle="modal" 
                                data-target="#display_modal"
                                 href='{{ route("modals.public_modal_display",["modal"=>"donation_modal","user_detail_id"=>$user_detail->id]) }}' class='btn btn-primary btn-block'>Add Donation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __("Emergency Contact") }}</h4>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class='col-12'>
                            <p class='card-text'>
                                Emergency Contact Person : {{ $user_detail->emeregency_contact_name }}
                            </p>
                            <p class='card-text'>
                                Emergency Contact Number : {{ $user_detail->emergency_contact }}
                            </p>
                            <p class='card-text'> Relation with Visitor : {{ $user_detail->relation_with_emergency_contact }}</p>
                        </div>
                    </div>
                </div>
                
                @if( ! $user_detail->user_mental_status->is_visitor_alone)
                    <div class='card-body bg-dark'>
                        <div class="row">
                            <div class='col-12'>
                                <h4 class='text-white'>Current Status :
                                    @if($user_registration->user_preferences->pending)
                                    <span class='text-info'>
                                        Pending
                                    </span>
                                    @elseif($user_registration->user_preferences->cancelled)
                                    <span class='text-warning'>
                                        Cancelled
                                    </span>
                                    @elseif($user_registration->user_preferences->confirmed)
                                    <span class='text-primary'>
                                        Confirmed
                                    </span>
                                    @elseif($user_registration->user_preferences->completed)
                                    <span class='text-success'>
                                        Course Completed
                                    </span>
                                    @elseif($user_registration->user_preferences->verified)
                                    <span class='text-success'>
                                        Verified
                                    </span>
                                    @endif
                                </h4>
                                <p>
                                    <form id="statusChange" action="{{ route('users.sadhak.sadhak-change-status',[$user_registration->id]) }}" method="POST">
                                    @csrf
                                        <label class='control-label text-white'>Select Status</label>
                                        <select name='status' id='user_status' class='form-control'>
                                            @if($user_registration->user_preferences->pending)
                                                <option>Change Status</option>
                                                @foreach ($action["pending"] as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                            @if($user_registration->user_preferences->verified)
                                                <option>Change Status</option>
                                                @foreach ($action["verified"] as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                            @if($user_registration->user_preferences->confirmed)
                                                <option>Change Status</option>
                                                @foreach ($action["confirmed"] as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif

                                            @if($user_registration->user_preferences->completed)
                                                @foreach ($action["completed"] as $key => $value )
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
    </div>

    <!-- Modal -->
            <!-- start modal -->
            <div class="modal fade text-left" id="display_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="myModalLabel1">User Update</h3>
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

      <!-- / Modal -->
</section>
@endSection()

@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script type="text/javascript">
        $(document).ready(function(){
            $('#display_modal').on('shown.bs.modal', function (event) {
                $.ajax({
                    method : "GET",
                    url : event.relatedTarget.href,
                    success: function (response){
                        $("#modal-content-fetch").html(response);
                    }
                });
            })
        });

        $("#user_status").change(function (event){
            console.log(this.value)
            $.ajax({
                method : "POST",
                url : $("form#statusChange").attr('action') + "/"+this.value,
                data :{"_token":"{{csrf_token()}}","status":this.value},
                success : function (response) {
                    console.log(response);
                } 
            })
        })
   </script>
@endSection()