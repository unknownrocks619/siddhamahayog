@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('events.admin_zoom_settings_add') }}" class='btn btn-primary'>
                        Create Zoom Account
                    </a>
                </div>
                <div class='card-body'>
                    <x-alert></x-alert>
                    <table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Country</th>
                                <th>Zoom Account</th>
                                <th>Avaibility</th>
                                <th>Sadhaks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settings as $zoom_setting)
                                <tr>
                                    <td> {{ $zoom_setting->sibir->sibir_title }} </td>
                                    <td>
                                        @if($zoom_setting->is_global) 
                                            International                                      
                                        @else
                                            {{ $zoom_setting->country->name }}
                                        @endif
                                        @if($zoom_setting->is_used && ! $zoom_setting->is_active)
                                                <br />
                                                @if($zoom_setting->is_global)
                                                    <a href="{{ route('events.admin_create_global_meeting') }}">
                                                @else
                                                    <a href="{{ route('events.admin_create_zonal_meeting',[$zoom_setting->country->id]) }}">
                                                @endif
                                                    Create Meeting
                                                </a>
                                            @elseif($zoom_setting->is_used && $zoom_setting->is_active)
                                                <br />
                                                <span class='text-success'>Live</span>
                                            @elseif($zoom_setting->meeting_id)
                                                <br />
                                                @if($zoom_setting->is_global)
                                                    <a href="{{ route('events.admin_create_zonal_registration',[$zoom_setting->id]) }}">Register Participants</a>
                                                @else
                                                    <a href="{{ route('events.admin_create_zonal_registration',[$zoom_setting->id]) }}">Register Participants</a>
                                                @endif
                                            @else
                                            <br />
                                            @if($zoom_setting->country)
                                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom_setting->country->id]) }}">Create Meeting</a>
                                            @endif

                                        @endif
                                    </td>
                                    <td>
                                        {{ $zoom_setting->username }}
                                    </td>
                                    <td>
                                        @if($zoom_setting->is_global)
                                            <span class='badge bg-secondary'>Global</span>
                                        @else
                                            <span class='badge bg-warning'>Isolated</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($zoom_setting->is_used && ! $zoom_setting->is_active)
                                                <br />
                                                @if($zoom_setting->is_global)
                                                <a href="{{ route('events.admin_create_global_meeting') }}">
                                                @else
                                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom_setting->country->id]) }}">
                                                @endif
                                                    Create Meeting
                                                </a>
                                            @elseif($zoom_setting->is_used && $zoom_setting->is_active)
                                                <br />
                                                <span class='text-success'>Live</span>
                                                <br />
                                                <a href="{{ route('events.admin_get_participants_list',[$zoom_setting->id]) }}">View Registered</a>
                                            @elseif($zoom_setting->meeting_id)
                                                <br />
                                                <a href="{{ route('events.admin_get_participants_list',[$zoom_setting->id]) }}">View Registered</a>
                                            @else
                                            <br />
                                            @if($zoom_setting->is_global)
                                                <a href="{{ route('events.admin_create_global_meeting') }}">Create Meeting</a>
                                            @else
                                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom_setting->country->id]) }}">Create Meeting</a>
                                            @endif

                                        @endif
                                    </td>
                                    <td>
                                        @if( ! $zoom_setting->is_used && !$zoom_setting->is_active)
                                            <form target="_blank" method="post" action="@if($zoom_setting->is_global) {{ route('events.admin_start_global_meeting',[$zoom_setting->id])}} @else {{ route('events.admin_start_zonal_setting',[$zoom_setting->id]) }} @endif">
                                                @csrf
                                                <button type="submit" class='btn btn-sm btn-primary'>Start Session</button>
                                            </form>
                                        @elseif( $zoom_setting->is_used && $zoom_setting->is_active)
                                            <form  method="post" action="@if($zoom_setting->is_global) {{ route('events.admin_end_global_setting',[$zoom_setting->id]) }} @else {{ route('events.admin_end_zonal_setting',[$zoom_setting->id]) }} @endif">
                                                @csrf
                                                <button type="submit" class='btn btn-sm btn-danger'>End Session</button>
                                            </form>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
   </script>
@endSection()