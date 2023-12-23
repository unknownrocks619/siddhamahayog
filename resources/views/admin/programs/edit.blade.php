@extends('layouts.admin.master')
@push('title') Edit :: {{$program->program_name}} @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a></span> Create
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 text-end">
            <button class="btn btn-primary"><i class="fas fa-arrow-left me-2"></i> Go Back</button>
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Update Program</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="program_name">Program Name</label>
                        <input type="text" value="{{$program->program_name}}" name="program_name" id="program_name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_type">Program Option</label>
                        <select name="program_type" id="program_type" class="form-control">
                            @foreach (\App\Models\Program::PROGRAM_TYPES as $key => $value)
                                <option value="{{$key}}" @if($program->program_type == $key) selected @endif>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_start_date">Program Start Date</label>
                        <input type="date" value="{{$program->program_start_date}}" name="program_start_date" id="program_start_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_end_date">
                            Program End Date
                        </label>
                        <input type="date" value="{{$program->program_end_date}}" name="program_end_date" id="program_end_date" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="tiny-mce form-control">{!! $program->description !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3 program_type paid">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="overdue_allowed">
                            Allow Access for Number days to unpaid user.
                        </label>
                        <input type="number" required class="form-control"
                               name="overdue_allowed" id="overdue_allowed" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="admission_fee">Admission Fee</label>
                        <input type="number" name="admission_fee" id="admission_fee" class="form-control" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="monthly_fee">Monthly Fee</label>
                        <input type="number" class="form-control" name="monthly_fee" id="monthly_fee" />
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            @foreach (\App\Models\Program::PROGRAM_STATUS as $key => $value)
                                <option value="{{$key}}" @if($key == $program->status) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="batch" class="d-flex justify-content-between">
                            <span>Default Batch</span>
                            <span>
                                <a href="" data-bs-target="#newBatch" data-bs-toggle="modal" class="ajax-modal" data-action="{{route('admin.modal.display',['view' => 'programs.batch.new','program'=>$program])}}"><i class="fas fa-plus me-2"></i> Create new batch</a>
                            </span>
                        </label>
                        <select name="batch" id="batch-select" class="form-control ajax-select-2"  data-action="{{route('admin.select2.batch-list')}}">
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="section" class="d-flex justify-content-between">
                            <span>Default Section</span>
                            <span>
                                <a href="" class="ajax-modal" data-bs-target="#newSection" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view'=>'programs.section.new','program' => $program->getKey()])}}">
                                    <i class="fas fa-plus"></i>
                                    Create New Section
                                </a>
                            </span>
                        </label>
                        <select name="section" id="section-select" class="form-control ajax-select-2" data-action="{{route('admin.select2.program-section-list',['program' => $program])}}"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Update Program
                    </button>
                </div>
            </div>
        </div>
    </div>
<x-modal modal="newSection"></x-modal>
<x-modal modal="newBatch"></x-modal>
@endsection
