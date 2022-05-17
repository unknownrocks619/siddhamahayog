@extends("layouts.portal.app")

@section("page_css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section("content")
    <section class="content file_manager">    
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>File Manager::{{ $course->resource_title }}</h2>                    
                    </div>            
                    <x-admin-breadcrumb>
                        <li class="breadcrumb-item">
                            <a href=''>{{$course->program->program_name}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href=''>{{$course->program_course->course_name}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">Other Resource</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $course->resource_title }}
                        </li>
                    </x-admin-breadcrumb>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Current</strong> Settings</h2>
                        </div>
                        <div class="body">
                            <p>
                                <strong>Program name:</strong> {{ $course->program->program_name }}

                            </p>
                            <p>
                                <strong>Course Name:</strong> {{ $course->program_course->course_name }}
                            </p>
                            <p>
                                <strong>Resource Type:</strong> @php echo (! $course->resource_type) ? "Text" : ucwords($course->resource_type) @endphp
                            </p>
                            <p>
                                <strong>Lock Status :</strong> @if($course->lock) <span class='badge badge-danger px-2'>Locked</span> @else <span class='badge badge-success'>Unlocked</span>@endif
                            </p>
                            <p>
                                <strong>Description resource :</strong> {{ $course->description }}
                            </p>

                        </div>
                    </div>
                </div>

                <div class="col-md-9">
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
                    <form name="resource_update" id="resource_update" method="post" action="{{ route('admin.resources.admin_update_course_resource',[$course->id]) }}">
                        @csrf
                        <div class="card">
                            <div class="header">
                                <h2><strong>Edit:: </strong> - {{ $course->resource_title }}</h2>
                                <ul class="header-dropdown">
                                    <li class="dropdown">
                                        <a href="{{ route('admin.videos.admin_list_videos_filemanager',[$course->program_id]) }}" class="btn btn-sm btn-danger" > 
                                            <i class="zmdi zmdi-close"></i> Close
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div id="errorShow"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>
                                                Resource Title
                                                <sup class="text-danger">
                                                    *
                                                </sup>
                                            </b>
                                            <input type="text" value="{{ $course->resource_title }}" name="resource_title" class='form-control' id="resource_title" />
                                            @error("resource_title")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>
                                                Resource Type
                                            </b>
                                            <select class="form-control" name='resource_type'>
                                                <option value='text' @if($course->resource_type == "text") selected @endif>Text</option>
                                                <option value='pdf' @if($course->resource_type == "pdf") selected @endif>Application / PDF</option>
                                                <option value='image' @if($course->resource_type == "image") selected @endif>Image</option>
                                            </select>
                                            @error("resource_type")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row mt-2 mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="program" class="label-control">
                                                Program
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <select name="program" id="program" class="form-control">
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course" class="label-control">
                                                Select Course
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <select name="course" id="course" class="form-control course_selection">

                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>
                                                Resource File
                                                <sub class="text-danger">Required Only if Resource type is PDF or Image</sub>
                                            </b>
                                            <input type="file" class="form-control" name="resource_file" placeholder="" />
                                            @error("resource_file")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror                      
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>
                                                Lock Resource After
                                            </b>
                                            <sub class='text-info'>(Number of Days)</sub>
                                            <input name='lock_after_days' type="number" class='form-control' class="form-control" value="{{$course->lock_after}}" />
                                            @error("lock_after_days")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <b>
                                                Resource Text
                                                <sub class="text-danger">Required Only if Resource type is Text</sub>
                                            </b>
                                            <textarea id="resource_text" class="form-control" name="resource_text">{{$course->description}}</textarea>
                                            @error("resource_text")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm ">Update Resource</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            tinymce.init({
            selector: 'textarea',
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
            });

            $("#program").change(function(){
                $("#course").select2({
                    placeholder : "Change Program to get list of course",
                    ajax: {
                        url : "{{ url()->full() }}",
                        dataType: 'json'
                    }
                })
            })
        });
    </script>


@endsection
