@extends('layouts.admin')

@section('page_css')
  <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
  <link ref='stylesheet' href='{{ asset("admin/app-assets/css/jquery.fancybox.min.css") }}' />
@endSection()

@section('content')
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">
                    Chapter Detail
                </h1>
            </div>
            <div class="card-body">
                <ul>
                    <li>Chapter Name: {{ $courseChapter->chapter_name }} </li>
                    <li>Description: {{ $courseChapter->description }}</li>
                </ul>
            </div>
            <div class="card-footer">
                <div class='row'>
                    <div class="col-8">
                        <a href="{{ route('chapters.admin_list_all_chapters') }}" >
                            <i class='fas fa-arrow-right'></i>
                            Go Back
                        </a>

                    </div>
                    <div class="col-4">
                        <a href="{{ route('chapters.lession.admin_course_add_video',$courseChapter->id) }}" id="" class='text-center'>
                            Upload / Add new video
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12" >
        <div class="row">
            <div class="col-12" style="display:none">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h4 class='text-white'>
                            Add New Video
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
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
                                                        $events = \App\Models\SibirRecord::get();
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
                                      
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            @foreach ($get_videos as $video)
                <div class="col-6">
                    <div class="card">
                        <div class="card-title bg-dark">
                            <h4 class='text-center text-white py-2'>{{ $video->video_title }}</h4>
                        </div>
                        <div class="card-body">
                            @if(strtolower($video->source) == "vimeo")
                            <div style="padding:56.25% 0 0 0;position:relative;">
                                <iframe src="https://player.vimeo.com/video/{{ $video->youtube_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                                </iframe>
                            </div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                            @endif
                            <p class='card-text'>
                                {{ $video->description }}
                            </p>
                        </div>
                        <div class='card-footer'>
                            <div class="row">
                                <div class="col-8">
                                    <label class="label-control">
                                        <a href="#" class='text-danger'>Delete Video</a>
                                    </label><br />
                                    <label class='label-control'>
                                    <a href="{{ route('chapters.lession.admin_edit_offline_video',[$video->id,'chapter'=>$courseChapter->id]) }}" class='text-info'>Edit</a>

                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class='label-control'>Re-Order Position</label>
                                    <select class='form-control'>
                                        @foreach ($total_sortable as $sortable )
                                            <option value="{{ $sortable }}" @if($video->sortable == $sortable ) selected @endif > {{ $sortable }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  </div>

</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
<script src="{{ asset ('admin/app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
<script src="{{ asset ('admin/app-assets/js/scripts/jquery.fancybox.min.js') }}"></script>
<script>
  $(document).on('keydown.fb', function (e) {

var keycode = e.keyCode || e.which;

if (keycode === 27) {

  e.preventDefault();

  parent.jQuery.fancybox.getInstance().close();

  return;
}

});
  </script>
@endSection()