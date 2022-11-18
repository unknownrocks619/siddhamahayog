@extends("layouts.portal.app")

@section("page_title")
::Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />


@endsection


@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program `{{$program->program_name}}`</h2>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card project_widget">
                    <div class="body">
                        <div class="row pw_content">
                            <div class="col-12 pw_header">
                                <h6>Available Sections</h6>
                            </div>
                            <div class='row'>
                                @foreach ($program->sections as $section)
                                <div class="col-md-12 mb-2">
                                    <h6 style="font-size:12px;">{{ $section->section_name }}</h6>
                                    <small class="text-danger">{{ $section->programStudents->count() }}
                                        Student(s)
                                    </small>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('admin.program.sections.admin_list_all_section',[$program->id]) }}" class='btn btn-info btn-block btn-sm'>Manage Section</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card project_widget">
                    <div class="body">
                        <div class="row pw_content">
                            <div class="col-12 pw_header">
                                <h6>Current Batch</h6>
                                <small class="text-muted">{{ $program->active_batch->batch->batch_name }} | {{ $program->active_batch->batch->batch_year }}/ {{ $program->active_batch->batch->batch_month }}</small>
                            </div>
                            <div class="col-8 pw_meta">
                                <span>Total Batch</span>
                                <small class="text-success">{{ $program->batches->count() }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('admin.program.batches.admin_batch_list',$program->id) }}" class='btn btn-info btn-block btn-sm'>Manage Batch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($program->liveProgram->count())
            <div class="col-lg-4 col-md-12">
                <div class="card project_widget">
                    <div class="body">
                        <div class="row pw_content">
                            <div class="col-12 pw_header">
                                <h6 class="text-success">This Program is Live</h6>
                            </div>
                            @foreach ($program->liveProgram as $live_program)
                            <div class="row">
                                <div class="col-8 pw_meta">
                                    <span>Started At: {{ $live_program->created_at }}</span>
                                    <small class="text-danger">
                                        @if($live_program->merge)
                                        This session is merged.
                                        @endif
                                    </small>
                                </div>
                                <div class="col-4">
                                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#000000">
                                        @if($live_program->section_id)
                                        <span class="btn btn-success-outline btn-sm">
                                            {{ $live_program->programSection->section_name }}
                                        </span>
                                        @else
                                        <span class="btn btn-outline-primary btn-sm">
                                            Open
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="border-bottom">
                                        <form action="{{ route('admin.program.live_program.end',[$live_program->id]) }}" method="post">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">End Session</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="http://" class='btn btn-info btn-block btn-sm'>Manage Resources</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <div class="body activities">
                        <div class="header">
                            <h2><strong>Quick</strong> Navigation</h2>
                        </div>
                        <div class="streamline b-accent">
                            <div class="sl-item">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a href="{{ route('admin.videos.admin_list_videos_filemanager',[$program->id]) }}">
                                            Resources

                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-primary">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a class='text-info text-link' href="{{ route('admin.program.courses.admin_program_course_list',[$program->id]) }}">
                                            Syllabus
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-warning">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a href="{{ route('admin.program.fee.admin_fee_overview_by_program',$program->id) }}" class="text-info text-link">
                                            Fee Collection
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-warning">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a href="{{ route('admin.members.admin_add_assign_member_to_program',$program->id) }}">
                                            Assign Student
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-warning">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a href="{{ route('admin.members.admin_add_member_to_program',$program->id) }}">
                                            Register Student
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-warning">
                                <div class="sl-content">
                                    <div class="text-muted">
                                        <a href="{{ route('admin.program.attendances.list',$program->id) }}">
                                            Attendance
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sl-item b-warning">
                                <div class="sl-content">
                                    <div class="text-muted">Exam Center</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                                Program
                            </strong>
                            student
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-hover" id="studentTable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>
                                        Full Name
                                    </th>
                                    <th>
                                        Phone Number
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Section
                                    </th>
                                    <th>
                                        Batch
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.admin_show_for_program',[$student->student->id,$program->id]) }}">{{ $student->student->full_name }}</a>
                                    </td>
                                    <td>
                                        {{ $student->student->phone_number }}
                                    </td>
                                    <td>
                                        {{ $student->student->email }}
                                    </td>
                                    <td>
                                        {{ $student->section->section_name }}
                                    </td>
                                    <td>
                                        {{ $student->batch->batch_name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.admin_show_for_program',[$student->student->id,$program->id]) }}">View Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        Student Record not found...
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if( $program->program_type == "paid" && $program->active_fees)
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Course Fee </strong> Structure</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{ route('admin.program.fee.admin_program_create_fee',[$program->id]) }}">Add Payment</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body m-b-10 bg-dark">
                        <div class="row">
                            <div class="col-6">
                                <small>Total Collected</small>
                                <h4 class="text-success m-b-0 m-t-0">
                                    @if($program->student_fee)
                                    {{ default_currency($program->student_fee->sum('total_amount')) }}
                                    @else
                                    {{ default_currency(0) }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif ($program->program_type == "paid" && ! $program->active_fees)
            <div class="col-lg-8 col-md-12" id="app">
                <div class="card">
                    <div class="header pt-0">
                        <h2>
                            <strong>Setup</strong> Fee Structure
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.program.fee.admin_store_course_fee',$program->id) }}" method="post">
                            @csrf
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admission_fee" class="label-control">
                                            Admission Fee
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" name="admission_fee" id="admission_fee" class="form-control @error('admission_fee') border border-danger @enderror " />
                                        @error("admission_fee")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="monthly_fee" class="label-control">
                                            Monthly Fee
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="monthly_fee" id="monthly_fee" class="form-control @error('monthly_fee') border border-danger @enderror" />
                                        @error("monthly_fee")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Update Fee Structure</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="row clearfix">
            <div class="col-md-12 col-lg-3">

            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="row profile_state">
                        <div class="col-lg-4 col-md-4 col-6">
                            <div class="body">
                                <h5 class="m-b-0">{{ ($program->active_fees && $program->active_fees->count()) ? default_currency($program->active_fees->admission_fee) : 0.00 }}</h5>
                                <span>Admission Fee</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-6">
                            <div class="body">
                                <h5 class="m-b-0">{{ ($program->active_fees && $program->active_fees->count()) ? default_currency($program->active_fees->monthly_fee) :0.00 }}</h5>
                                <span>Monthly Fee</span>
                            </div>
                        </div>
                        <div class="col-lg-34 col-md-4 col-6">
                            <div class="body">
                                <h5 class="m-b-0">
                                    @php
                                    $total = ($program->active_fees && $program->active_fees->count()) ? $program->active_fees->admission_fee + $program->active_fees->monthly_fee : 0;
                                    echo default_currency($total);
                                    @endphp
                                </h5>
                                <span>Total</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <div class="moda-body">
                <p>Please wait...loading your data</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
@if ($program->program_type == "paid" && ! $program->active_fees)
<script src="{{ mix ('js/app.js')}}"></script>
@endif

<script>
    $("#studentTable").DataTable()
</script>
<script>
    // $('#student-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{{url()->full()}}',
    //     columns: [
    //         {data: 'id',name:"id"},
    //         {data: 'program_name', name: 'program_name'},
    //         {data: "program_duration",name: "program_duration"},
    //         {data: "promote", name: "promote"},
    //         {data: "batch", name: "batch"},
    //         {data: "action", name: "action"}
    //     ]
    // });
</script>

@endsection