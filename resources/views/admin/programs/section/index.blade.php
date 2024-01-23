@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{route('admin.program.admin_program_list')}}">Programs</a>/ <a href="{{route('admin.program.admin_program_detail',['program'=> $program->getKey()])}}">{{$program->program_name}}</a></span> Manage Sections
    </h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-3">
                <a class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_list')}}"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="col-md-9 col-sm-12 mb-3">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a data-bs-target="#createNewSection" data-bs-toggle="modal" class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_list')}}"><i class="fas fa-plus"></i></a>
                        <a href="{{route('admin.program.sections.admin_list_all_section', ['program' => $program->getKey()])}}" class="btn btn-secondary disabled">Sections</a>
                        <a  href="" class="btn btn-primary">Batch</a>
                        @include('admin.datatable-view.programs.live',['row' => $program])
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($all_sections as $section)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(($current_tab && $current_tab == str($section->section_name)->slug()->value()) || (! $current_tab && $loop->first)) active @endif" id="section-{{$section->getKey()}}-tab" data-bs-toggle="tab" data-bs-target="#tabContent_{{$section->getKey()}}" type="button" role="tab" aria-controls="home" aria-selected="true">
                                        {{$section->section_name}}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($all_sections as $section)
                                <div class="tab-pane fade show @if(($current_tab && $current_tab == str($section->section_name)->slug()->value()) || (! $current_tab && $loop->first)) active @endif" id="tabContent_{{$section->getKey()}}" role="tabpanel" aria-labelledby="section-{{$section->getKey()}}-tab">
                                    <div class="card-datatable table-responsive my-2 border-bottom">
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                                <h4 class="card-header">{{$section->section_name}}</h4>
                                                <div class="">
                                                    @if( ! $section->default)
                                                    <button type="button" data-confirm="You are about to delete the section from this program. Members from this section will be transferred to default section. Do you wish to continue." class="btn btn-danger btn-icon data-confirm"><i class="fas fa-trash"></i></button>
                                                    <button type="button" data-method="get" data-action="{{route('admin.program.sections.admin_update_default_section',['program'=>$program,'section' => $section])}}" data-confirm="Mark this section as default." class="btn btn-info btn-icon data-confirm"><i class="fas fa-star"></i></button>
                                                    @endif
                                                    <button class="btn btn-primary">Assign Student</button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table section-datatable" data-action="{{route('admin.program.sections.admin_list_student_section',['program'=> $program,'section'=> $section])}}" data-section-id="{{$section->getKey()}}">
                                            <thead>
                                            <tr class="thead-background-color">
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                @include('admin.programs.partials.quick-navigation')
            </div>
        </div>

    </div>
    <x-modal modal="assignStudentToProgramSections"></x-modal>
    <x-modal modal="createNewSection">
        @include('admin.modal.programs.section.new',['program' => $program,'callback' => 'refresh'])
    </x-modal>
@endsection

@push('page_script')
    <script>
        var offSetHeight = parseFloat($('#layout-menu').height()) + parseFloat($('nav').height()) + 20;
        console.log(offSetHeight);
        $.each($('.section-datatable'), function(index,elm) {
            let _actionUrl = $(elm).data('action');

            $(elm).DataTable({
                    processing: true,
                    ajax: _actionUrl,
                    pageLength: 100,
                    serverSide: true,
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
                        //     data : 'enrolled_date',
                        //     name: 'enrolled_date'
                        // },
                        // {
                        //     data: "action",
                        //     name: "action"
                        // }
                    ],
            });
        })
    </script>
@endpush

@push('page_css')
    <style>
        tbody {
            display:block;
            overflow:auto;
        }
        thead, tbody tr {
            display:table;
            width:100%;
            table-layout:fixed;
        }
    </style>
@endpush
