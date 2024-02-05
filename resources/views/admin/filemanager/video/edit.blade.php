@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">
                    <a href="{{route('admin.program.admin_program_list')}}">Programs</a>
                
                    @php
                    if (isset($program) ) {
                        $close_link = route('admin.videos.admin_list_videos_filemanager',[$program->id]);
                    

                        echo ' / ';
                            echo "<a href='".route('admin.program.courses.admin_program_course_list',[$program->id])."'>";
                                echo  $video->course->course_name;
                            echo "</a>";

                        echo " / ";
                            echo "<a href='".route('admin.videos.admin_list_videos_filemanager',$program->id)."'>";
                                echo "Videos Resource";
                            echo "</a>";
                    }
                @endphp
                / </span> {{$video->lession_name}} 

            </h4>
        </div>

        <div class="col-md-2 text-end">
            <a href="{{route('admin.program.courses.admin_program_course_list',[$program->id])}}" class="btn btn-icon btn-danger">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                <form name="course_form" class="ajax-component-form" id="new_lession" method="post" action="{{ route('admin.videos.update.admin_video',[$video->id]) }}">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="lession_name">
                                            Lesson Name
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>

                                        <input type="text" value="{{ $video->lession_name }}" name="lession_name" required class='form-control' id="lession_name" />
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label for="description">
                                            Description
                                        </label>
                                        <textarea class='form-control' name='description' id="description">{{$video->video_description}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="total_duration">
                                            Total Video Duration
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input value="{{ $video->total_duration }}" type="text" required class="form-control" id="total_duration" name="total_video_duration" placeholder="HH:MM:SS" />                      
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <b>
                                            Video Publish Date
                                        </b>
                                        <input type="date" value="{{$video->lession_date}}" class="form-control" name="video_publish_date" />
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="lock_video_after">
                                            Lock Video After
                                        </label>
                                        <sup class='text-danger'>(Number of Days)</sup>
                                        <input type="number" value="{{ $video->lock_after }}" class='form-control' class="form-control" value="0" />
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="video_source">
                                            Video Source
                                        </label>
                                        <input type="text" readonly class='form-control' class="form-control" value="Vimeo" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="video_link">
                                            Vimeo Video Link
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input required value="{{ $video->video_link }}" type="url" name="vimeo_video_url" id="vimeo_video_url" class="form-control" />

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary btn-block">Update Video Detail</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function(){
            tinymce.init({
            selector: 'textarea',
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
            });
        });
    </script>


@endsection
