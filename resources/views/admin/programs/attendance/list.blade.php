@php $storedCount = []; @endphp
@extends('layouts.admin.master')
@push('page_title') Program > {{$program->program_name}} > Attendance @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a> / <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">{{$program->program_name}}</a> / </span> Attendance
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 text-end">
            <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-danger btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
    </div>
    <form action="{{route('admin.program.attendances.list', [ 'program' => $program->getKey()])}}" method="get">
        <!-- Responsive Datatable -->
        <div class="card my-2">
            <h5 class="card-header">Attendance Filter </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date_range">Date Range</label>
                            <input type="text" name="filter_dates" id="date_range" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="member_type">Member Type</label>
                            <select name="filter_member" id="member_type" class="form-control">
                                <option value="">Select Member Type Filter</option>
                                <option value="paid">Paid Member</option>
                                <option value="unpaid">Unpaid Member</option>
                                <option value="enrolled">Enrolled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select name="filter_section" id="section" class="form-control">
                                <option value="">Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section['id'] }}">
                                        {{ $section['section_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Attendance Data </h5>
        <div class="card-body">
            <div class="row" id="datatableWrapper"></div>
            <table class="table table-bordered table-hover w-100" id="attendance">
                <thead>
                <tr>
                    <th>
                        Sadhak Name
                    </th>
                    <th>
                        Contact
                    </th>
                    @include('adminv1.programs.attendance.partial.dynamic-header')
                    <th>
                        Info
                    </th>
                </tr>
                </thead>
                <tbody>
                    @include('adminv1.programs.attendance.partial.attendance-sheet')
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end" colspan="2">Total Count:</td>
                        @foreach ($dateSheet as $date_sheet)
                            <th>
                                @if (isset($storedCount[$date_sheet->attendance_id]))
                                    <span class="d-block badge bg-label-success px-2 fs-5 mb-1">
                                        P : {{ $storedCount[$date_sheet->attendance_id]['present'] }}
                                    </span>
                                    <span class="d-block badge bg-label-danger px-2 fs-5">A :
                                        {{ $storedCount[$date_sheet->attendance_id]['absent'] }}
                                    </span>
                                @endif
                            </th>
                        @endforeach
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('page_script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        let table = $('#attendance').DataTable({
                        lengthChange: true,
                        dom: 'Blfrtip',
                        buttons : {
                           buttons : [
                               {extend: 'copy', className: 'btn btn-primary'},
                               {extend: 'excel', className: 'btn btn-primary'},
                               {extend: 'pdf', className: 'btn btn-primary'},
                               // {extend: 'colvis', className: 'btn btn-danger'},
                           ]
                        },
                    });

        table.buttons().container()
            .appendTo('#datatableWrapper .col-md-6:eq(0)')

        $(document).on('click', 'a.dt-button', function (event) {
            if (!$(this).hasClass('active')) {
                $(this).css('background', '#a59a9a !important');
                $(this).removeClass('bg-info');
            } else {
                $(this).addClass('bg-info');
                $(this).css('background', 'red !important');
            }
        });
        $(function() {
            flatpickr("#date_range",{
                mode : 'range',
                dateFormat : 'Y-m-d'
            });
        })
    </script>
@endpush

@push('page_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
