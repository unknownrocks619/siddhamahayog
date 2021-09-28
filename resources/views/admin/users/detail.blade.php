@extends('layouts.admin')

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
                        @else
                            (
                            <a 
                                data-toggle="modal" 
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_petname_modal','user_detail_id'=>$user_detail->id]) }}">
                               Add Pet Name
                            </a>
                            )
                        @endif
                        </span>
                        <br />
                        @if ( $user_detail->userverification && $user_detail->userverification->verified)
                            <small style='font-weight:100 !important;font-size:12px;' class='text-success'>
                                <a href="{{ route('users.view-service-detail',[$user_detail->id,'verification']) }}" class='text-success'>
                                    Verified
                                </a>
                            </small>
                        @else
                            <small style='font-weight:100 !important;font-size:12px;' class='text-danger'>
                                <a href="{{ route('users.view-service-detail',[$user_detail->id,'verification']) }}" class='text-danger'>
                                    Unverified
                                </a>
                            </small>
                        @endif
                    </h4>
                </div>
                @include ('admin.users.detail.navigation')
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
                            <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>{{ $user_detail->address() }}</li>
                            <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i>{{ $user_detail->phone_number }} </li>
                            <li><i class="cursor-pointer bx bx-time mb-1 mr-50"></i>July 10</li>
                            <li id='display_email_address'><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i>
                                @if(isset ($user_detail->userlogin->email)) 
                                    {{ $user_detail->userlogin->email }} 
                                @else 
                                <a  data-toggle="modal" 
                                    data-target="#display_modal" 
                                    id='add_email_modal' 
                                    href="{{ route('modals.display',['modal'=>'add_user_email_modal','user_detail_id'=>$user_detail->id]) }}">
                                    Add Email
                                </a>
                                @endif
                            </li>
                            <li id='display_email_address'>
                                <i class="cursor-pointer bx bx-calendar mb-1 mr-50"></i>
                                {{  $user_detail->date_of_birth_nepali }}
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
                        @endif
                    </div>
                </div>
               
                  <div class="row" id="marital_status_info">
                    <div class="col-sm-6 col-12">
                      <h6><small class="text-muted">Marrital Status</small></h6>
                      <p>
                          {{ $user_detail->marritial_status }}
                      </p>
                    </div>
                    <div class="col-sm-6 col-12">
                      <h6><small class="text-muted">Marrital Information</small></h6>
                      <p>
                        @if($user_detail->marritial_status == "Married" && (int) $user_detail->married_to_id)
                            <a href="{{ route('users.view-user-detail',$user_detail->married_to_id) }}">
                                {{ $user_detail->parent->full_name() }}
                            </a>
                        @elseif($user_detail->marritial_status == "Married" &&  $user_detail->married_to_id)

                            {{  $user_detail->married_to_id }}
                        
                        @else
                            <a
                                data-toggle="modal"
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_maritial_modal','user_detail_id'=>$user_detail->id]) }}"
                            >
                                Add Infomration
                            </a>
                        @endif

                      </p>
                    </div>
                    <div class="col-sm-6 col-12">
                      <h6><small class="text-muted">Intial Reference </small></h6>
                      <p id="user_verification_show">
                                @if($user_detail->userreference && $user_detail->userreference->name)
                                    {{ $user_detail->userreference->name }}
                                @else
                                    <a data-toggle="modal"
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_reference_modal','user_detail_id'=>$user_detail->id]) }}">
                                        Add Reference
                                    </a>
                                @endif
                      </p>
                    </div>
                    <div class="col-sm-6 col-12">
                      <h6><small class="text-muted">Intail Center Reference</small></h6>
                        <p>
                            @if($user_detail->userreference && $user_detail->userreference->center_id)
                                {{ $user_detail->userreference->branches->name }}
                            @else
                                <a data-toggle="modal"
                                    data-target="#display_modal"
                                    href="{{ route('modals.display',['modal'=>'user_reference_modal','user_detail_id'=>$user_detail->id]) }}">
                                    Add Center
                                </a>
                            @endif
                        </p>
                    </div>
                    <div class="col-12">
                      <h6><small class="text-muted">User Status</small></h6>
                      <p>
                      {{ $user_detail->user_type }} 
                      </p>
                    </div>
                  </div>
                  <a href="{{ route('users.edit_user_detail',$user_detail->id) }}" class="btn btn-sm d-none d-sm-block float-right btn-light-primary mb-2">
                    <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>Edit</span>
                  </a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __("General Information") }}</h4>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class='col-12'>
                            <h4>Total Donation</h4>
                            <p>
                                NRs
                                @php 
                                    $donation_detail = $user_detail->donation;
                                @endphp
                                @if ($donation_detail && $donation_detail->amount) 
                                    {{ $donation_detail->amount }}
                                    (
                                        <a href="{{ route('users.view-service-detail',[$user_detail->id,'donations']) }}">View Detail</a>
                                    )
                                @else
                                0
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-12'>
                            <h4>Night Spent</h4>
                            <p>
                                @php
                                    $nights = $user_detail->night;
                                    if ($nights && $nights->nights) {
                                        echo "Days " . $nights->nights;
                                        echo "(";
                                @endphp
                                   <a href="{{ route('users.view-service-detail',[$user_detail->id,'nights']) }}">View Detail</a>
                                @php
                                echo ")";
                                    } else {
                                        echo "0 Day";
                                    }
                                @endphp
                            </p>
                        </div>
                    </div>
                </div>


                <div class='card-body bg-dark'>
                    <div class="row">
                        <div class='col-12'>
                            <h4 class='text-white'>Interested Sewas</h4>
                            <p>
                                @if($user_detail->user_sewa)
                                    @foreach ($user_detail->user_sewa as $sewa_interested)
                                        <span class='badge badge-primary'>
                                        {{ $sewa_interested->usersewa->sewa_name }}
                                        </span>
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-12'>
                            <h4 class='text-white'>Involved In Sewas</h4>
                            <p>
                            @if($user_detail->user_assigned_sewa)
                                    @foreach ($user_detail->user_assigned_sewa as $sewa_interested)
                                        <span class='badge badge-success' style="background:green">
                                        {{ $sewa_interested->usersewa->sewa_name }}
                                        </span>
                                    @endforeach
                                    <br /><br />
                                    <a href="{{ route('users.view-service-detail',[$user_detail->id,'sewas']) }}">View Detail</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Modal -->
            <!-- start modal -->
            <div class="modal fade text-left" id="display_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
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
   </script>
@endSection()