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
                    <li class="breadcrumb-item active">Batch</li>
                </x-admin-breadcrumb>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <x-alert></x-alert>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-5">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Available</strong> Batch
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li>
                                            <a data-target="#create_section" data-toggle="modal" href="javascript:void(0);">
                                                Add Batch
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
                                    <th>Batch</th>
                                    <th>Active</th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($batches as $batch)
                                <tr>
                                    <td>
                                        {{ $batch->batch->batch_name }}
                                    </td>
                                    <td>
                                        {{ $batch->batch->batch_year }}-{{ $batch->batch->batch_month }}
                                    </td>
                                    <td>
                                        @if($program->active_batch && $batch->batch->id == $program->active_batch->batch_id)
                                        <span class="btn btn-sm btn-success">
                                            Default
                                        </span>
                                        @else
                                        <span class="btn btn-primary btn-sm">
                                            Active
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.program.batches.admin_batch_students',[$program->id,$batch->batch_id]) }}" class="studentList">View Student</a>
                                        @if(! $program->active_batch || $program->active_batch->batch_id != $batch->batch->id)
                                        |
                                        <form action="{{ route('admin.program.batches.admin_batch_udpate_status',[$program->id,$batch->id]) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary btn-link text-white">
                                                Make Default
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Batch Not Included
                                    </td>
                                </tr>
                                @endforelse
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
            <form method="post" action="{{ route('admin.program.batches.admin_batch_store',$program->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="title" id="largeModalLabel">{{ $program->program_name }} - <small>Add Batche</small></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>
                                        Select Batch
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </b>
                                    <select name="batch" id="batch" class="form-control">
                                        @foreach ($all_batches as $batch_list)
                                        <option value='{{ $batch_list->id }}'>{{ $batch_list->batch_name }} ({{ $batch_list->batch_year }}-{{ $batch_list->batch_month }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>
                                        Make Default Batch
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
    $("#edit_create_section").on("shown.bs.modal", function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.href,
            success: function(response) {
                $("#edit_section_modal").html(response);
            }
        })
    });
    $(".studentList").on("click", function(event) {
        event.preventDefault();
        $.ajax({
            method: "get",
            url: $(this).attr("href"),
            success: function(response) {
                $("#student_list_section").html(response);
            }
        })
    })
</script>
@endsection