@extends('layouts.portal.app')

@section('page_title')
    Edit Program
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Programs</h2>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('success') }}</span>
                            </div>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('error') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="header">
                            <h2><strong>Update</strong> Program Detail </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button"
                                        onclick="window.location.href='{{ route('admin.program.admin_program_list') }}'"
                                        class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i>
                                        Close</button>
                                </li>
                            </ul>
                        </div>
                        <div id="app">
                            <form action="" method="post" class="ajax-append">
                                <div class="card">
                                    <div class="body">
                                        <div class="row clearfix mt-3">
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b for="account_name">Program Name
                                                        <sup class='text-danger'>*</sup>
                                                    </b>
                                                    <input type="text" class="form-control" name="program_name"
                                                        id="program_name" require value="{{ $program->program_name }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Program Type
                                                        <sup class='text-danger'>*</sup>
                                                    </b>
                                                    <select name="program_type" id="program_type" class='form-control'
                                                        required>
                                                        <option value="paid"
                                                            @if ($program->program_type == 'paid') selected @endif>Paid</option>
                                                        <option value="open"
                                                            @if ($program->program_type == 'open') selected @endif>Open</option>
                                                        <option value="registered_user"
                                                            @if ($program->program_type == 'registered_user') selected @endif>Registered
                                                            User
                                                        </option>
                                                        <option value="club"
                                                            @if ($program->program_type == 'club') selected @endif>Club</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="fields.program_type == 'paid'" class="row clearfix mt-3">
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b for="account_name">Monthly Fee
                                                        <sup class='text-danger'>*</sup>
                                                    </b>
                                                    <input type="text" class="form-control" name="monthly_fee"
                                                        id="monthly_fee" value="{{ $program->monthly_fee }}" require />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Admission Fee
                                                        <sup class='text-danger'>*</sup>
                                                    </b>
                                                    <input type="text" class="form-control" name="admission_fee"
                                                        id="admission_fee" require value="{{ $program->admission_fee }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix mt-3">
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Program Start Date
                                                    </b>
                                                    <input type="date" class="form-control" value=""
                                                        name="program_duration_start" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Program Start Date
                                                    </b>
                                                    <input type="date" class="form-control"
                                                        name="program_duration_end" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix mt-3">
                                            <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Write Something About Program
                                                    </b>
                                                    <textarea class="form-control" name="description" id="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix mt-3">
                                            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Promote
                                                    </b>
                                                    <div class="radio">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="radio" name="promote" id="promote_yes"
                                                                    value="yes">
                                                                <label for="promote_yes" class='text-success'>
                                                                    Yes, Promote in Website
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="radio" checked name="promote"
                                                                    id="promote_no" value="no">
                                                                <label for="promote_no" class='text-danger'>
                                                                    No, Don't Promote in Website
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="fields.program_type == 'paid'"
                                                class="col-lg-6  col-md-6 col-sm-12 m-b-20">
                                                <div class="form-group">
                                                    <b>Allow Access for Number days to unpaid user.
                                                        <span class="text-danger">*</span>
                                                    </b>
                                                    <input type="number" required class="form-control"
                                                        name="overdue_allowed" id="overdue_allowed" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer clearfix mt-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class='btn btn-primary btn-block'>Update Program
                                                    Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_script')
    <script src="{{ asset('assets/js/admin.js') }}"></script>
@endsection
