@php
    $modules = App\Models\NavigationItem::whereNull('parent_id')->get();
@endphp
@extends('layouts.admin.master')
@push('page_title')Staff List @endpush

@section('main')
    @if( adminUser()->role()->isSuperAdmin())
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Users /</span> Update
            </h4>
            @if($center->getKey())
            <a href="{{route('admin.centers.list',['center' => $center])}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            @else
            <a href="{{route('admin.users.list')}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            @endif

        </div>
    </div>
    @endif
    <!-- Responsive Datatable -->
    <div class="card">
        <form class="ajax-form" action="{{route('admin.users.edit',['user' => $user])}}" method="post">
            <div class="card-body">
                <div class="bg-light p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" value="{{$user->firstname}}" name="firstname" id="firstname" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" value="{{$user->lastname}}" name="lastname" id="lastname" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="email"  @if( ! adminUser()->role()->isSuperAdmin()) disabled @endif value="{{$user->email}}" name="email" id="email" class="form-control" />
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
                        @if( adminUser()->role()->isSuperAdmin())
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    @if ( ! $center->getKey() )
                                    <select name="role" id="role">
                                        @foreach (App\Models\Role::$roles as $key => $value)
                                            <option value="{{$key}}" @if($user->role_id == $key ) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        <span class="form-control disabled">{{App\Models\Role::$roles[2]}}</span>
                                        <input type="hidden" name="role" value="2" class="form-control" />
                                    @endif
                                    {{-- <select name="role" id="role">
                                        @foreach (App\Models\Role::$roles as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tagline">Tagline
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" @if( ! adminUser()->role()->isSuperAdmin()) disabled @endif value="{{$user->tagline}}" name="tagline" id="tagline" class="form-control" />
                            </div>
                        </div>
                    </div>
                    @if( adminUser()->role()->isSuperAdmin())
                        <div class=" my-4 row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="center">Center</label>
                                    @if($center->getKey())
                                        <span class="form-control disabled">{{$center->center_name}}</span>
                                        <input type="hidden" name="center" value="{{$center->getKey()}}" class="form-control" />
                                    @else
                                        <select name="center" id="center" class="form-control">
                                            <option value="">Select Center</option>
                                            @foreach (App\Models\Centers::where('active', true)->get() as $center)
                                                <option value="{{$center->getKey()}}" @if($user->center_id == $center->getKey()) selected @endif> {{$center->center_name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if( ! $center->getKey() )
                    <div class="row mt-4 d-none">
                        <div class="col-md-12">
                            <h4>
                                Permission
                            </h4>
                        </div>
                    </div>

                    <div class="row d-none">
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
                        <div class="row d-none">
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

                    <div class="row d-none">
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
                @endif
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary">
                            Update Profile Info
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
