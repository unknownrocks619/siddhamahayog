@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class='row'>

                        @if( ! $zoom->is_active && $zoom->is_global)
                            <div class='col-4'>
                                <a href="{{ route('events.admin_register_participants_to_sibir',[$zoom->id]) }}" class='btn btn-primary registration'>
                                    Begin Registration
                                </a>
                            </div>
                        @endif
                        @if( ! $zoom->is_active && ! $zoom->is_global)
                            <div class='col-4'>
                            <a class="btn btn-primary" href="{{ route('events.admin_create_zonal_registration',[$zoom->id]) }}">
                                    Begin Registration
                                </a>
                            </div>
                        @endif
                        @if(! $zoom->is_active)
                        <div class='col-4'>
                            <form target="_blank" method="post" action="@if($zoom->is_global) {{ route('events.admin_start_global_meeting',[$zoom->id])}} @else {{ route('events.admin_start_zonal_setting',[$zoom->id]) }} @endif">
                                @csrf
                                <button type="submit" class="btn btn-success">Start Session</button>
                            </form>
                            <!-- <a href="{{-- route('events.admin_start_global_meeting',[$zoom->id]) --}}" class='btn btn-success'>Start Meeting</a> -->
                        </div>
                        @else
                        <div class='col-4'>
                            <form method="post" action="@if($zoom->is_global) {{ route('events.admin_end_zonal_setting',[$zoom->id])}} @else {{ route('events.admin_end_global_setting',[$zoom->id]) }} @endif">
                                @csrf
                                <button type="submit" class="btn btn-danger">End Session</button>
                            </form>
                            <!-- <a href="{{-- route('events.admin_start_global_meeting',[$zoom->id]) --}}" class='btn btn-success'>Start Meeting</a> -->
                        </div>
                        <div class='col-4'>
                        <form target="_blank" method="post" action="@if($zoom->is_global) {{ route('events.admin_start_global_meeting',[$zoom->id])}} @else {{ route('events.admin_start_zonal_setting',[$zoom->id,'type'=>'rejoin']) }} @endif">
                                @csrf
                                <button type="submit" class="btn btn-success">Reconnect Session</button>
                            </form>
                            <!-- <a href="{{-- route('events.admin_start_global_meeting',[$zoom->id]) --}}" class='btn btn-success'>Start Meeting</a> -->
                        </div>
                        @endif
                        @if( ! $zoom->is_active && !$zoom->is_used)           
                            <div class='col-4'>
                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom->country_id]) }}" class='btn btn-warning'>Recreate Meeting</a>
                            </div>
                        @elseif (! $zoom->is_active)
                            <div class='col-4'>
                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom->country_id]) }}" class='btn btn-warning'>Create Meeting</a>
                            </div>

                        @endif
                    </div>
                    @if($zoom->is_active)
                    <div class='row'>
                        <div class='col-md-12'>
                            <p class='text-success'>This is currently Live.</p>
                        </div>
                    </div> 
                    @endif
                </div>
                <div class='card-body'>
                    <div class='row mb-3' id="progress" style="display:none">
                        <div class='col-md-12'>
                            <div class="progress" style="height: 2.6rem;">
                                <div class="progress-bar progress-bar-animated progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    <span style="font-size:20px;">Processing.. Please wait..</span> 
                                </div>
                            </div>
                            <span class='text-danger'>This will take some time. Do not close this window.</span>
                        </div>
                    </div>
                    <div style="display:none" id="alert_message">
                    </div>               
                    <x-alert></x-alert>
                    <form class='mb-2' method="post" action="{{ route('events.admin_add_user_to_meeting') }}">
                        @csrf
                        <input type="hidden" name="current_meeting" value="{{$zoom->id}}" />
                        <input type="search" class="form-control" name="search" placeholder="Search by loginID or Email" />
                        <input type="submit" class='btn btn-primary mt-2' value="Search and Add" />
                    </form>
                    <div id="search_filter_result"></div>
                    <table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $registered_user = \App\Models\UserSadhakRegistration::where('sibir_record_id',$zoom->sibir_record_id);
                                if ($zoom->is_global) {
                                    $registered_user->with(["userdetail"]);
                                } else {
                                    $registered_user->with(['userdetail'=>function($query) use ($zoom){
                                            return $query->where('country',$zoom->country_id);
                                        },"zoom_registration"]);
                                }

                                $sadhaks= $registered_user->paginate(20);
                            @endphp
                            @forelse ($sadhaks as $participant)
                                @if($participant->userdetail)
                                    @php
                                         $registration = \App\Models\SadhakUniqueZoomRegistration::where('meeting_id',$zoom->meeting_id)
                                                            ->where("user_detail_id",$participant->userdetail->id)
                                                            ->where('sibir_record_id',$zoom->sibir_record_id)
                                                            ->first();
                                        // $registration = false;
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $participant->userdetail->full_name() }}
                                        </td>
                                        <td>
                                            @if($registration)
                                                <span class='text-success'>Registered</span>
                                            @else
                                                <span class='text-danger'>Not Registered</span>

                                            @endif

                                        </td>
                                        <td>
                                            @if($zoom->is_active && $registration && $registration->have_joined)
                                                <span class='bg-success text-white px-2'>In Meeting</span>
                                            @endif
                                            
                                            @if( ! $registration )
                                                <a href="{{ route('events.admin_create_zonal_registration',[$zoom->id,'user'=>$participant->userdetail->id]) }}" class='btn btn-success btn-sm'>Register Sadhak</a>
                                            @else 
                                                <a href="{{ route('events.admin_revoke_zoom_access',[$zoom->id,'user'=>$participant->userdetail->id]) }}" class='btn btn-danger btn-sm '>Revoke Access</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                
                            @empty
                            <tr>
                                <td colspan="3">
                                    0 Participants Have been registered.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    {{ $sadhaks->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-8">
            <div class="card">
                <!-- Card flex-->
            </div>
        </div>
    </div>
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

        $("a.registration").click(function(event) {
            event.preventDefault();
            var current_url = $(this).attr('href');
            $("#progress").fadeIn("fast");
            $.ajax({
                type : "get",
                url : $(this).attr("href"),
                data : "register_all=true",
                async : true,
                success : function (response ) {
                    $("#progress").fadeOut('slow',function(){
                        if (response.success == true){
                            $("#alert_message").attr("class",'alert alert-success')
                        } else {
                            $("#alert_message").attr("class",'alert alert-danger')
                        }
                    });
                    $("#alert_message").html(response.message);
                    $("#alert_message").fadeIn('medium');
                    window.location.href;

                }                
            });
            return false;
        });

        $("form").submit(function(event) {
            event.preventDefault();
            $.ajax({
                method : $(this).attr("method"),
                url : $(this).attr('action'),
                data: $(this).serializeArray(),
                success: function (response) {
                    if (response.success == true){
                            $("#alert_message").attr("class",'alert alert-success')
                        } else {
                            $("#alert_message").attr("class",'alert alert-danger')
                        }
                    $("#alert_message").html(response.message);
                    $("#alert_message").fadeIn('medium');
                }
            })
        })
   </script>
@endSection()