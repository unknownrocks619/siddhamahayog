@php
    $modules = App\Models\NavigationItem::whereNull('parent_id')->get();
@endphp
@extends('layouts.admin.master')
@push('page_title')Staff List @endpush

@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Users /</span> Create
            </h4>
            <a href="{{route('admin.users.list')}}" class="btn btn-primary btn-icon">
                <i class="fas fa-plus"></i>
            </a>
        
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <form class="ajax-form" action="{{route('admin.users.create')}}" method="post">
            <div class="card-body">
                <div class="bg-light p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="firstname" id="firstname" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="lastname" id="lastname" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="email" name="email" id="email" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="password" name="password" id="password" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role">
                                    @foreach (App\Models\Role::$roles as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tagline">Tagline
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="tagline" id="tagline" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4>
                            Permission
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-2">
                        View
                    </div>
                    <div class="col-md-2">
                        Edit
                    </div>
                    <div class="col-md-2">
                        Delete
                    </div>
                    <div class="col-md-2">
                        Quick Navigation
                    </div>
                </div>
                @foreach ($modules as $navigation)
                    <div class="row">
                        <div class="col-md-4">
                            <h5>{{$navigation->name}}</h5>
                            <input type="hidden" name="module_name[]" value="{{$navigation->name}}" />
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" name="view[{{$loop->iteration}}]" value="1">
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" name="edit[{{$loop->iteration}}]" value="1">
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" name="delete[{{$loop->iteration}}]" value="1">
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" name="quick_navigation[{{$loop->iteration}}]" value="1">
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="text-danger">Finanace Information</h5>
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="module_name[{{$modules->count() + 1}}]" value="finance">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="view[{{$modules->count() + 1}}]" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="edit[{{$modules->count() + 1}}]" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="quick_navigation[{{$modules->count() + 1}}]" value="1">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary">
                            Create New User
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
