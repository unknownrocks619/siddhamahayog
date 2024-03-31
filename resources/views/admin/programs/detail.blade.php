@php
/** @var  \App\Models\Program $program */

$totalStat = collect($program->totalAdmissionFee('admission_fee'));
$admission_fee = $totalStat->where('total_by','admission_fee')->first();
$monthly_fee = $totalStat->where('total_by','monthly_fee')->first();
$total_revenue = $totalStat->where('total_by','grand_total')->first();
@endphp

@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a>/</span> {{$program->program_name}}
    </h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-3">
                <a class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_list')}}"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="col-md-9 col-sm-12 mb-3">
                <div class="row">
                    <div class="col-md-12 text-end">
                        @if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
                            <a href="{{route('admin.program.sections.admin_list_all_section', ['program' => $program->getKey()])}}" class="btn btn-primary">Sections</a>
                            <a href="{{route('admin.program.batches.admin_batch_list', ['program' => $program->getKey()])}}" class="btn btn-primary">Batch</a>
                        @endif
                        @if(in_array(adminUser()->role(), \App\Models\Program::GO_LIVE_ACCESS))
                            @include('admin.datatable-view.programs.live',['row' => $program])
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(adminUser()->role()->isSuperAdmin())
            <div class="row">
                <div class="col-xl-12 mb-4 col-lg-12 col-12">
                    @include('admin.programs.partials.statistics',['program' => $program])
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Enrolled Student
                        </h4>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class=" table" id="program-table">
                            <thead>
                            <tr>
                                <th>
                                    @if($program->getKey() == 5 )
                                        Total Jap
                                    @else
                                        Roll Number
                                    @endif
                                </th>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Address</th>
{{--                                <th>Payment Info</th>--}}
{{--                                <th>Batch Name</th>--}}
{{--                                <th>Section name</th>--}}
                                <th>Member Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>
                                    @if($program->getKey() == 5 )
                                        Total Jap
                                    @else
                                        Roll Number
                                    @endif
                                </th>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Address</th>
{{--                                <th>Payment Info</th>--}}
{{--                                <th>Batch Name</th>--}}
{{--                                <th>Section name</th>--}}
                                <th>Member Date</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                @include('admin.programs.partials.quick-navigation')
            </div>
        </div>

    </div>
    <x-modal modal="assignStudentToProgram"></x-modal>
    <x-modal modal="liveSessionModal"></x-modal>
@endsection

@push('page_script')

    <script>
        $('#program-table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            aaSorting: [],
            pageLength: 250,
            ajax: '{{url()->full()}}',
            columns: [
                {
                    data: 'roll_number',
                    name: 'roll_number'
                },
                {
                    data: "full_name",
                    name: "full_name"
                },
                {
                    data: "phone_number",
                    name: "phone_number"
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data : "country",
                    name : 'country'
                },
                {
                    data : 'full_address',
                    name : 'full_address'
                },
                // {
                //     data : "total_payment",
                //     name: "total_payment"
                // },
                // {
                //     data: "batch",
                //     name: "batch"
                // },
                // {
                //     data : 'section',
                //     name: 'section'
                // },
                {
                    data : 'enrolled_date',
                    name: 'enrolled_date'
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });

    </script>
@endpush
