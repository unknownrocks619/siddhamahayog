@extends('layouts.admin.master')
@push('page_title') Volunteer List @endpush
@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">
                    <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">Programs</a>/</span> Volunteer
            </h4>
            @if(adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin())
                <div class="row mb-2">
                    <div class="col-md-12 text-end">
                        <a href="{{route('admin.program.admin_program_new')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Program</a>
                    </div>
                </div>

            @endif
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Program Volunteer List </h5>

        <div class="card-datatable table-responsive">
            @include('admin.programs.volunteer.partials.list')
        </div>
    </div>
@endsection

@include('admin.programs.partials.footer-script')
@push('page_script')
    <script>
        $('#volunteerList').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            aaSorting: [],
            pageLength: 250,
            ajax: '{{url()->full()}}',
            columns: [
                {
                    data: "full_name",
                    name: "full_name"
                },
                {
                    data: "phone_number",
                    name: "phone_number"
                },
                {
                    data : 'gotra',
                    name: 'gotra'
                },
                {
                    data : 'full_address',
                    name : 'full_address'
                },
                {
                    data: "education",
                    name: "education"
                },
                {
                    data : "profession",
                    name : 'profession'
                },
                {
                    data : 'action',
                    name : 'action'
                }
            ]
        });

    </script>
@endpush