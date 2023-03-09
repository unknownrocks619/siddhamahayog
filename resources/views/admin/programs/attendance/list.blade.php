@php
    $storedCount = [];
@endphp
@extends('layouts.portal.app')

@section('content')
    <section class="content file_manager">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Section Management::{{ $program->program_name }}</h2>
                    </div>
                    <x-admin-breadcrumb>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.program.admin_program_detail', [$program->id]) }}">{{ $program->program_name }}</a>
                        </li>
                        <li class="breadcrumb-item active">Batch</li>
                    </x-admin-breadcrumb>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <x-alert></x-alert>
                </div>
            </div>

            <form action="{{ route('admin.program.attendances.list', [$program->id]) }}" method="get">
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
                                            <input type="text" name="filter_dates" id="dates" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="filter_member">Member Type</label>
                                            <select name="filter_member" id="filter_member" class="form-control">
                                                <option value="all">Enrolled</option>
                                                <option value="paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filter_section">Section</label>
                                        <select name="filter_section" id="filter_section" class="form-control">
                                            @foreach ($sections as $section)
                                                <option value="{{ $section['id'] }}">
                                                    {{ $section['section_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="footer d-flex justify-content-space">
                                <button type="submit" class="btn btn-primary">Filter Result</button>
                                @if (request()->dates)
                                    <a href="{{ route('admin.program.attendances.list', $program->getKey()) }}"
                                        class="btn btn-danger">Clear Filter</a>
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
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button"
                                        onclick="window.location.href='{{ route('admin.program.admin_program_detail', [$program->id]) }}'"
                                        class="btn btn-danger btn-sm boxs-close">
                                        <i class="zmdi zmdi-close"></i> Close</button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <table class="table table-bordered table-hover w-100" id="attendance">
                                <thead>
                                    <tr>
                                        <th>
                                            Sadhak Name
                                        </th>
                                        <th>
                                            Contact
                                        </th>
                                        @include('admin.programs.attendance.partial.dynamic-header')
                                        <th>
                                            Info
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.programs.attendance.partial.attendance-sheet')
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            Total Count:
                                        </th>
                                        @php $storedCount = $GLOBALS['attendance']; @endphp
                                        @foreach ($dateSheet as $date_sheet)
                                            <th>
                                                @if (isset($storedCount[$date_sheet->attendance_id]))
                                                    <span class="badge badge-success px-2 text-white">P :
                                                        {{ $storedCount[$date_sheet->attendance_id]['present'] }}</span>
                                                    <br />
                                                    <span class="badge badge-danger px-2 text-white">A :
                                                        {{ $storedCount[$date_sheet->attendance_id]['absent'] }}</span>
                                                @endif
                                            </th>
                                        @endforeach
                                        <th>

                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page_script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
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

        $(document).ready(function() {
            let table = $("#attendance").DataTable({
                dom: 'Blfrtip',
                lengthChange: true,
                buttons: [{
                    'extend': 'csv',
                    'split': ['copy', 'excel', 'pdf'],
                }, 'colvis'],
                scrollX: true,
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)')

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
        $('input[name="filter_dates"]').daterangepicker();

        $(document).on('click', 'a.dt-button', function(event) {
            if (!$(this).hasClass('active')) {
                $(this).css('background', '#a59a9a !important');
                $(this).removeClass('bg-info');
            } else {
                $(this).addClass('bg-info');
                $(this).css('background', 'red !important');
            }
        });
    </script>
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

    <style type="text/css">
        a.buttons-columnVisibility {
            background-color: red !important;
            color: #fff !important;
        }

        a.dt-button {
            background: red !important;
            color: #fff !important;
        }
    </style>
@endsection
