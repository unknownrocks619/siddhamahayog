@php
    /** @var  \App\Models\Program $program */
@endphp

@extends('layouts.admin.master')
@push('page_title') Group list@endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a> / <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">{{$program->program_name}}</a> /</span> Groups
    </h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 mb-3 d-flex justify-content-between">
                <div>
                    <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-danger btn-icon">
                        <i class="fas fa-arrow-left"></i></a>
                </div>
                <div>
                    <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-primary btn-icon">
                        <i class="fas fa-plus"></i></a>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Group List
                        </h4>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class=" table" id="program-table">
                            <thead>
                            <tr>
                                <th>
                                   Group Name
                                </th>
                                <th>Total Member</th>
                                <th>Auto Enable</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{$group->group_name}}</td>
                                        <td>0</td>
                                        <td>
                                            @if($group->enable_auto_ading)
                                                <span class="badge bg-label-sucess">Yes</span>
                                            @else
                                                <span class="badge bg-label-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            View | Edit
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>
                                    Group Name
                                </th>
                                <th>Total Member</th>
                                <th>Auto Enable</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-modal modal="assignStudentToProgram"></x-modal>
@endsection

@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <script>
        $('#program-table').DataTable();

    </script>
@endpush
