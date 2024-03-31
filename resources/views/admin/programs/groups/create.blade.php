@php
    /** @var  \App\Models\Program $program */
@endphp

@extends('layouts.admin.master')
@push('page_title') Group list@endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a> / <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}">{{$program->program_name}}</a> / <a href="{{route('admin.program.admin_program_grouping_list',['program' => $program])}}">Groups</a> /</span> Create
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
        <form action="{{route('admin.program.admin_program_group_create',['program' => $program])}}" method="post" class="ajax-component-form">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Create New Group
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="group_name">Group name
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="group_name" id="group_name" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="card_sample">Card Sample
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="file" name="card_sample" id="card_sample" class="form-control" />
                                    </div>
                                </div>

                            </div>
                            

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="print_size_height">Actual Print Size In Height (in Pixel)
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="number" name="print_size_height" id="print_size_height" class="form-control">
                    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="print_size_width">
                                            Actual Print Size in Width (in Pixel)
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="number" name="print_size_width" id="print_size_width" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_colour">Primary Colour
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="color"  name="primary_colour" id="primary_colour" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-4 rule-wrapper">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="rules" class="fs-3">Rules</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="text" name="amount[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label >Operator</label>
                                                <select name="operator[]"  class="form-control">
                                                    <option value="gt"> > </option>
                                                    <option value="gtq"> >= </option>
                                                    <option value="lt"> < </option>
                                                    <option value="ltq"> <= </option>
                                                    <option value="eq"> = </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label >Connector</label>
                                                <select name="connector[]"  class="form-control">
                                                    <option value="">-</option>
                                                    <option value="or">OR</option>
                                                    <option value="and" selected>AND</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-end action-button">
                                            <button class="btn-primary btn-icon btn" type="button" onclick="window.programGroup.addRules(this,{appendTo:'.rule-wrapper'})"><i class="fas fa-plus"></i></button>
                                        </div>
            
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_include">Auto Update User</label>
                                        <select name="auto_include" id="auto_include" class="form-control">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-primary" type="submit">Create New Group</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
