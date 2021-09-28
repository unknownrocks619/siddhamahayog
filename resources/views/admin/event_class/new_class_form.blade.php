@extends('layouts.admin')


@section('content')
<section class="users-edit">
    <div class="card">
        <div class='card-header px-2 py-2 bg-dark text-white'>
            <h4 class='card-title text-white'>Add New Class </h4>
        </div>
        <x-alert></x-alert>
        <form method="POST" action="{{ route('events.admin_video_save') }}">
        @csrf
            <div class='card-body mt-2'>
                <div class='row'>
                    <div class='col-md-6 col-sm-12'>
                        <!-- <h5>Center Information</h5> -->
                        <div class='form-group'>
                            <label class='control-label'>Select Event</label>
                            <select name='event' class='form-control'>
                                @php
                                    foreach ($events as $event){
                                        if ( ! $event->event_class){
                                            echo "<option value='{$event->id}'>{$event->sibir_title}</option>";
                                        }
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Class Medium</label>
                            <input type="text" name='class_medium' class='form-control' value="ZOOM" readonly />
                        </div>
                    </div>
                    <div class='col-md-6 col-sm-12'>
                        <div class='form-group'>
                            <label class='control-label'>Meeting ID</label>
                            <input type="text" name='meeting_id' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Meeting Password</label>
                            <input type="text" name='meeting_password' class='form-control' value="" />
                        </div>

                    </div>

                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <label class='label-control'>Meeting URL</label>
                        <textarea name='meeting_url' class='form-control'></textarea>
                    </div>
                </div>
                <div class='row mt-3'>
                    <div class="col-md-6">
                        <label class='label-control'>Start Date & Time</label>
                        <input type="datetime-local" name='event_start' class='form-control' />
                    </div>
                </div>
            </div>
            <div class='card-footer'>
            <div class='row'>
                    <div class='col-md-10'>
                        <button type='submit' class='btn btn-primary btn-block'>Add Class</button>
                    </div>
                    <div class='col-md-2'>
                        <a href="{{ route('events.admin_video_class_list') }}">Go Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endSection()

@section('page_js')
<!-- <script src="{{ asset ('admin/app-assets/js/scripts/pages/dashboard-analytics.min.js') }}"></script> -->
@endSection()