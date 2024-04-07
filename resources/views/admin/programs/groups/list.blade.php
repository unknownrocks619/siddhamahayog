@php
    /** @var  \App\Models\Program $program */
@endphp

@extends('layouts.admin.master')
@push('page_title') Group list @endpush
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
                    <a href="{{route('admin.program.admin_program_group_create',['program' => $program])}}" class="btn btn-primary btn-icon">
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
                                        <td>{{$group->group_member_count}}</td>
                                        <td>
                                            @if($group->enable_auto_adding)
                                                <span class="badge bg-label-success">Yes</span>
                                            @else
                                                <span class="badge bg-label-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.program.admin_program_group_edit',['program' => $program,'group'=> $group])}}" class="btn btn-icon btn-primary">
                                                <i class="fas fa-pencil"></i>
                                            </a>
                                            <a href="{{route('admin.program.admin_program_group_edit',['program' => $program,'group'=> $group,'tab' => 'groups'])}}" class="btn btn-icon btn-primary">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a href="{{route('admin.program.amdmin_group_card_view',['program' => $program,'group'=> $group])}}" class="btn btn-icon btn-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button data-method="post" data-action="{{route('admin.program.admin_program_group_delete',['program' => $program,'group'=> $group])}}" class="btn btn-icon btn-danger data-confirm" data-confirm="You are about to delete the group, this will delete all children group and all people associated with the group. Do you wish to continue.">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
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
