@extends("layouts.portal.app")

@section("content")
    <section class="content file_manager">    
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>File Manager::{{ $program->program_name }}</h2>                    
                    </div>            
                    <x-admin-breadcrumb>
                        <li class="breadcrumb-item"><a href=''>File Manager</a></li>
                        @php
                            if (isset($program) ) {
                                $close_link = route('admin.videos.admin_list_videos_filemanager',[$program->id]);
                                echo '<li class="breadcrumb-item">';
                                    echo "<a href='".route('admin.program.admin_program_detail',[$program->id])."'>";
                                        echo  $program->program_name;
                                    echo "</a>";
                                echo "</li>";

                                echo '<li class="breadcrumb-item">';
                                    echo "<a href='".route('admin.program.courses.admin_program_course_list',[$program->id])."'>";
                                        echo  $video->course->course_name;
                                    echo "</a>";
                                echo "</li>";

                                echo "<li class='breadcrumb-item'>";
                                    echo "<a href='".route('admin.videos.admin_list_videos_filemanager',$program->id)."'>";
                                        echo "Videos Resource";
                                    echo "</a>";
                                echo "</li>";
                                echo "<li class='breadcrumb-item active'>";
                                    echo $video->lession_name; 
                                echo "</li>";
                            }
                        @endphp
                    </x-admin-breadcrumb>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    </div>
                @endif
                    <form name="course_form" id="new_lession" method="post" action="{{ route('admin.videos.update.admin_video',[$video->id]) }}">
                        @csrf
                        <div class="card">
                            <div class="header">
                                <h2><strong>Edit:: </strong> - {{ $video->lession_name }}</h2>
                                <ul class="header-dropdown">
                                    <li class="dropdown">
                                        <a href="{{ $close_link }}" class="btn btn-sm btn-danger" > 
                                            <i class="zmdi zmdi-close"></i> Close
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <b>
                                                    Lession Name
                                                    <sup class="text-danger">
                                                        *
                                                    </sup>
                                                </b>
                                                <input type="text" value="{{ $video->lession_name }}" name="lession_name" required class='form-control' id="lession_name" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <b>
                                                    Description
                                                </b>
                                                <textarea class='form-control' name='description' id="description">{{$video->video_description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b>
                                                    Total Video Duration
                                                    <sup class="text-danger">*</sup>
                                                </b>
                                                <input value="{{ $video->total_duration }}" type="text" required class="form-control" name="total_video_duration" placeholder="HH:MM:SS" />                      
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b>
                                                    Video Publish Date
                                                </b>
                                                <input type="date" value="{{$video->lession_date}}" class="form-control" name="video_publish_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b>
                                                    Lock Video After
                                                </b>
                                                <sup class='text-danger'>(Number of Days)</sup>
                                                <input type="number" value="{{ $video->lock_after }}" class='form-control' class="form-control" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b>
                                                    Video Source
                                                </b>
                                                <input type="text" readonly class='form-control' class="form-control" value="Vimeo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <b>
                                                    Vimeo Video Link
                                                </b>
                                                <sup class="text-danger">*</sup>
                                                <input required value="{{ $video->video_link }}" type="url" name="vimeo_video_url" id="vimeo_video_url" class="form-control" />

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <b>Thumbnail</b>
                                                <input type="file" name="thumbnail" id="thumbnail" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-block btn-sm ">Update Video Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
