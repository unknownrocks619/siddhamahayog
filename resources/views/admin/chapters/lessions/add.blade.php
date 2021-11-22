@extends('layouts.admin')


@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('chapters.lession.admin_course_videos',$courseChapter->id) }}">Go Back </a>
        </div>
        <div class='card-header px-2 py-2 bg-dark text-white'>
            <h4 class='card-title text-white'>Update Video Profile</h4>
        </div>
        <x-alert></x-alert>
        <form enctype="multipart/form-data" method="POST" action="{{ route('chapters.lession.admin_store_new_video',$courseChapter->id) }}">
        @csrf
            <div class='card-body mt-2'>
                <div class='row'>
                    <div class='col-md-6 col-sm-12'>
                        <!-- <h5>Center Information</h5> -->
                        <div class='form-group'>
                            <label class='control-label'>Class Medium</label>
                            <select name='class_medium' class='form-control'>
                                <option value="YOUTUBE" @if(old('class_medium') == "YOUTUBE") selected @endif>Youtube</option>
                                <option value="VIMEO" @if(old('class_medium') == "VIMEO") selected @endif>Vimeo</option>
                                <option value="UPLOAD" @if(old('class_medium') == "UPLOAD") selected @endif>Upload</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Video Title</label>
                            <input type="text" name='video_title' class='form-control' value="{{ old('video_title') }}" />
                        </div>
                        <div class="form-group">
                            <label class='control-label'>
                                Select Chapter
                            </label>                                
                        <input type="text" readonly class='form-control' value="{{ $courseChapter->chapter_name }}" />

                        </div>
                        <div class="form-group">
                            <label class='control-label'>Total Video Length</label>
                            <input type="text" value="{{ old('video_time') }}" class="form-control" placeholder="HH:MM:SS" name="video_time" />
                        </div>

                    </div>
                    <div class='col-md-6 col-sm-12'>
                        <div class='form-group'>
                            <label class='control-label'>Video Source Link</label>
                            <input type="text" name='youtube_link' class='form-control' value="{{ old('youtube_link') }}" />
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
                <div class="row">
                    <div class="col-12">
                        <label for="description" class='label-control'>Video Description</label>
                        <textarea class='form-control' id='description' name='description'>{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            <div class='card-footer'>
                <div class='row'>
                    <div class='col-md-10'>
                        <button type='submit' class='btn btn-primary btn-block'>Update Video Detail</button>
                    </div>
                    <div class='col-md-2'>
                        <a href="{{ route('chapters.lession.admin_course_videos',$courseChapter->id) }}">Go Back</a>
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