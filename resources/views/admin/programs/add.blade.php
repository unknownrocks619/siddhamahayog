@extends('layouts.admin.master')

@push('title') Create Program @endpush

@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a></span> Create
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 text-end">
            <a href="{{route('admin.program.admin_program_list')}}" class="btn btn-primary"><i class="fas fa-arrow-left me-2"></i> Go Back</a>
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="card">
        <form action="{{route('admin.program.admin_program_new')}}" method="post" class="ajax-form">
            <h5 class="card-header">Add New Program</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="program_name">Program Name</label>
                            <input type="text" name="program_name" id="program_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program_type">Program Option</label>
                            <select name="program_type" id="program_type" class="form-control">
                                @foreach (\App\Models\Program::PROGRAM_TYPES as $key => $value)
                                    <option value="{{$key}}">
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
                            <input type="date" name="program_start_date" id="program_start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program_end_date">
                                Program End Date
                            </label>
                            <input type="date" name="program_end_date" id="program_end_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="tiny-mce form-control"></textarea>
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
            </div>
            <div class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Program
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
