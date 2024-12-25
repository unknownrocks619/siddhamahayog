@extends('layouts.admin.master')
@push('page_title') Zoom Accounts - Edit @endpush
@section('main')
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between align-items-center">

            <h4 class="">
                <span class="text-muted fw-light">Zoom/</span> Accounts / Edit
            </h4>

            <a href="{{route('admin.zoom.admin_zoom_account_show')}}" class="btn btn-danger btn-icon text-white">
                <i class="fas fa-arrow-left"></i>
            </a>

        </div>
    </div>
    <form action="{{route('admin.zoom.admin_zoom_account_edit',['zoom' => $zoom])}}" class="ajax-append ajax-form" method="post">
        <!-- Responsive Datatable -->
        <div class="card">
            <h5 class="card-header">Edit</h5>

            <div class="card-body">
                <div class="row clearfix mt-3">
                    <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                        <div class="form-group">
                            <label for="account_name">Name
                                <sup class='text-danger'>*</sup>
                            </label>
                            <input type="text" class="form-control" value="{{$zoom->account_name}}" name="name" id="account_name" required />

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                        <div class="form-group">
                            <label for="account_name">Account Status
                                <sup class='text-danger'>*</sup>
                            </label>
                            <select name="status" id="account_status" class='form-control' required>
                                <option value="active" @if($zoom->account_status == 'active') selected @endif>Active</option>
                                <option value="suspend" @if($zoom->account_status == 'suspend') selected @endif>Suspend</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row clearfix my-4">
                    <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                        <div class="form-group">
                            <label for="account_username">
                                Zoom Registered Email
                                <sup class="text-danger">
                                    *
                                </sup>
                            </label>
                            <input type="email" value="{{$zoom->account_username}}" name="username" id="" class="input-group form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                        <div class="form-group">
                            <label for="category">
                                Account Access Category
                                <sup class="text-danger">
                                    *
                                </sup>
                            </label>
                            <select name="category" id="category" class="form-control">
                                @foreach (\App\Models\ZoomAccount::ACCESS_TYPES as $key => $value)
                                    <option value="{{$key}}" @if($key == $zoom->category) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row clearfix mt-3">
                    <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                        <div class="form-group">
                            <label for="api_token">
                                Developer API TOKEN
                                <sup class="text-danger">*</sup>
                            </label>
                            <textarea name="api_token" disabled placeholder="paste your token here" id="api_token" cols="30" rows="6" class='form-control'>{{str()->mask($zoom->api_token,'...',10)}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

