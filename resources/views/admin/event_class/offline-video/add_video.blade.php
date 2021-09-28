@extends('layouts.admin')


@section('content')
<section class="users-edit">
    <div class="card">
        <div class='card-header px-2 py-2 bg-dark text-white'>
            <h4 class='card-title text-white'>Add Offline Video</h4>
        </div>
        <x-alert></x-alert>
        <form enctype="multipart/form-data" method="POST" action="{{ route('events.admin_offline_video_save') }}">
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
                                        echo "<option value='{$event->id}'>{$event->sibir_title}</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Class Medium</label>
                            <select name='class_medium' class='form-control'>
                                <option value="YOUTUBE">Youtube</option>
                                <option value="VIMEO">Vimeo</option>
                                <option value="UPLOAD">Upload</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Video Title</label>
                            <input type="text" name='video_title' class='form-control' value="" />
                        </div>
                    </div>
                    <div class='col-md-6 col-sm-12'>
                        <div class='form-group'>
                            <label class='control-label'>Video Source Link</label>
                            <input type="text" name='youtube_link' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Status</label>
                            <select name="active" class='form-control'>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Upload Video</label>
                            <input type="file" name='upload' class='form-control' />
                        </div>
                    </div>  
                </div>
            </div>
            <div class='card-footer'>
            <div class='row'>
                    <div class='col-md-10'>
                        <button type='submit' class='btn btn-primary btn-block'>Add Video Source</button>
                    </div>
                    <div class='col-md-2'>
                        <a href="{{ route('events.admin_offline_video_list') }}">Go Back</a>
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