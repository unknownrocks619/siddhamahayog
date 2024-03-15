@php
    /** @var  \App\Models\Program $program */
@endphp

@extends('layouts.admin.master')
@push('page_title') Group Update @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a> / <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">{{$program->program_name}}</a> / <a href="{{route('admin.program.admin_program_grouping_list',['program' => $program])}}">Groups</a> /</span> {{$group->group_name}}
    </h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 mb-3 d-flex justify-content-between">
                <div>
                    <a href="{{route('admin.program.admin_program_grouping_list',['program' => $program])}}" class="btn btn-danger btn-icon">
                        <i class="fas fa-arrow-left"></i></a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($tabs as $tab)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if($tab['name'] == $active_tab) active @endif" id="tab-{{$tab['name']}}-tab" data-bs-toggle="tab" data-bs-target="#tabContent_{{$tab['name']}}" type="button" role="tab" aria-controls="home" aria-selected="true">
                                        {{$tab['label']}}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            @foreach ($tabs as $tab)
                                <div class="tab-pane fade show @if($tab['name'] == $active_tab) active @endif" id="tabContent_{{$tab['name']}}" role="tabpanel" aria-labelledby="section-{{$tab['name']}}-tab">
                                    @include('admin.programs.groups.tabs.'.$tab['name'],['group' => $group,'program' => $program,'groups' => $groups])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 d-none">
                @include('admin.programs.partials.quick-navigation')
            </div>
        </div>



    </div>

@endsection
