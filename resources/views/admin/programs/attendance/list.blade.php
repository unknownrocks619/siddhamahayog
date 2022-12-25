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

        <form action="{{ route('admin.program.attendances.list',[$program->id]) }}" method="get">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Filter</strong>
                                Result
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dates">Date Range</label>
                                        <input type="text" name="dates" id="dates" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer d-flex justify-content-space">
                            <button type="submit" class="btn btn-primary">Filter Result</button>
                            @if(request()->dates)
                            <a href="{{ route('admin.program.attendances.list',$program->getKey()) }}" class="btn btn-danger">Clear Filter</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Attendance</strong> List
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-hover   w-100" id="attendance">
                            <thead>
                                <tr>
                                    <th>
                                        Sadhak Name
                                    </th>
                                    <th colspan="{{ $presentList->count() }}">
                                        Date
                                    </th>
                                <tr>
                                    <th>

                                    </th>
                                    @foreach ($presentList as $dateLoop)
                                    <th>
                                        {{ date('Y-m-d',strtotime($dateLoop->created_at)) }}
                                    </th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($program->students as $students)
                                <tr>
                                    <td>
                                        {{ $students->student->full_name }}
                                        ( {{ $students->student->email }} )
                                    </td>
                                    @foreach ($presentList as $liveMeetingRecord)
                                    <?php
                                    $record = route('admin.program.attendances.detail', [$program->getKey(), $students->student->getKey(), $liveMeetingRecord->meeting_id]);
                                    $currentStudentId = $students->student->getKey();
                                    $present = $liveMeetingRecord->attendances()->where('student', $currentStudentId)->exists() ?? false
                                    ?>
                                    <td class="text-white bg-{{ ($present) ? 'success' : 'danger' }}">
                                        @if( $present )
                                        <button type='button' class="btn-link text-white" data-href="{{ $record }}">Present (view)</button>
                                        @else
                                        Absent
                                        @endif
                                    </td>
                                    @endforeach
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
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
    $("#attendance").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
    })
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
    $('input[name="dates"]').daterangepicker();
</script>
@endsection

@section('page_css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endsection