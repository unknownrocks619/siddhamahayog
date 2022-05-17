@extends("layouts.portal.app")

@section("content")
    <section class="content file_manager">    
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Section Management::{{ $program->program_name }}</h2>                    
                    </div>            
                    <x-admin-breadcrumb>
                    <li class="breadcrumb-item"><a href="{{ route('admin.program.admin_program_detail',[$program->id]) }}">{{ $program->program_name }}</a></li>
                        <li class="breadcrumb-item active">Section</li>
                    </x-admin-breadcrumb>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Available</strong> Sections
                                <ul class="header-dropdown">
                                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                        <ul class="dropdown-menu slideUp">
                                            <li>
                                                <a data-target="#create_section" data-toggle="modal" href="javascript:void(0);">
                                                    Add Section
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </h2>
                        </div>
                        <div class="body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Section Name</th>
                                        <th>Enrolled</th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_sections as $section)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration  }}
                                            </td>
                                            <td>
                                                {{ $section->section_name }}
                                            </td>
                                            <td>
                                                19
                                            </td>
                                            <td>
                                                <a href="http://">View Students</a>
                                                <br /> 
                                                <a href="{{ route('admin.program.sections.admin_edit_section',$section->id) }}" data-toggle="modal" data-target="#edit_create_section">Edit</a>
                                                |
                                                <a href="">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Student</strong> List
                            </h2>
                        </div>
                        <div class="body" id='student_list_section'>
                            <p>Click On 'View Student' to display list of student on particular section</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("modal")
<div class="modal fade" id="create_section" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role='document'>
        <div class="modal-content" id="section_modal">
            <form method="post" action="{{ route('admin.program.sections.admin_store_section',$program->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="title" id="largeModalLabel">{{ $program->program_name }} - <small>Create Section</small></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>
                                        Section Name
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </b>
                                    <input type="text" name="section_name" required class='form-control' id="section_time" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>
                                        Make Default Section
                                        <sup class="text-danger">*</sup>
                                    </b>
                                    <div class="form-group">
                                        <div class="radio inlineblock m-r-20">
                                            <input type="radio" name="default" id="default_yes" class="with-gap" value="1">
                                            <label for="default_yes">Yes</label>
                                        </div>                                
                                        <div class="radio inlineblock">
                                            <input type="radio" name="default" id="default_no" class="with-gap" value="0" checked="">
                                            <label for="default_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm ">Create New Section</button>
                            </div>
                        </div>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_create_section" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role='document'>
        <div class="modal-content" id="edit_section_modal">
            <h4>Please wait.. Loading Content.</h4>
        </div>
    </div>
</div>

@endsection

@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript">
        $("#edit_create_section").on("shown.bs.modal", function (event) {
            $.ajax({
                method : "get",
                url : event.relatedTarget.href,
                success : function (response) {
                    $("#edit_section_modal").html(response);
                }
            })
        });
    </script>
@endsection