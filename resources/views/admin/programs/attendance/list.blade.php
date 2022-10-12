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
            <div class="col-lg-4">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Filter</strong> Result
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.program.attendances.list',[$program->id]) }}" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>
                                            Start Date
                                        </b>
                                        <input type="date" name="start_date" id="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <b>
                                            End Date
                                        </b>
                                        <input type="date" name="end_date" id="end_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <b>
                                            Section
                                        </b>
                                    </div>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Filter Result
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Attendance</strong> List
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        Sadhak Name
                                    </th>
                                    <th colspan="{{ $program->allLivePrograms->count() }}">
                                        Date
                                    </th>
                                    <th colspan="2">
                                        Attendance
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach ($program->allLivePrograms as $program_date)
                                    <th>{{ date("Y-m-d",strtotime($program_date->created_at)) }}</th>
                                    @endforeach
                                    <th>
                                        Present
                                    </th>
                                    <th>Absent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($program->students as $students)
                                <tr>
                                    <td>
                                        {{ $students->student->full_name }}
                                    </td>
                                    <td>
                                        <?php 
                                            
                                        ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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