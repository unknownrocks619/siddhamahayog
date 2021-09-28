@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class='row'>
                        @if( ! $zoom->is_active)
                            <div class='col-4'>
                                <a href="{{ route('events.admin_register_participants_to_sibir',[$zoom->id]) }}" class='btn btn-primary registration'>
                                    Begin Registration
                                </a>
                            </div>
                        @endif
                        <div class='col-4'>
                            <form method="post" action="{{ route('events.admin_start_global_meeting',[$zoom->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Start Meeting</button>
                            </form>
                            <!-- <a href="{{-- route('events.admin_start_global_meeting',[$zoom->id]) --}}" class='btn btn-success'>Start Meeting</a> -->
                        </div>
                        @if( ! $zoom->is_active)           
                            <div class='col-4'>
                                <a href="{{ route('events.admin_create_zonal_meeting',[$zoom->country_id]) }}" class='btn btn-warning'>Recreate Meeting</a>
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
                    <table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                                
                            @forelse ($participants as $participant)
                                <tr>
                                    <td>
                                        {{ $participant->user->full_name() }}
                                    </td>
                                    <td>
                                        Registered
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="3">
                                    0 Participants Have been registered.
                                </td>
                            </tr>

                            @endforelse
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
@endSection()