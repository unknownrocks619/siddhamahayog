@extends('layouts.admin.master')
@push('title') Members > Add New Member / Sadhak @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            @if(isset($program) )
                <a href="{{route('admin.program.admin_program_detail',['program' => $program->getKey()])}}">{{$program->program_name}}</a> /
            @endif
            <a href="{{route('admin.members.all')}}">Members</a> / </span> Add New Member
    </h4>

    @php
        $route = route('admin.members.admin_store_member_to_program');

        if ( isset($program) && $program ) {
            $route = route('admin.members.admin_store_member_to_program',['program' => $program->getKey()]);
        }

    @endphp
    <form action="{{$route}}" method="post" class="ajax-form">

        <div class="card">
            <div class="card-body">
                @if(isset($program) && $program)
                    <input type="hidden" name="callback" value="assignUserToProgram" />
                    <input type="hidden" name="params[program]" value="{{$program->getKey()}}">
                @endif

                <div class="row my-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_name">
                                First Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" name="first_name" id="first_name" value="" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="middle_name">
                                Middle Name
                            </label>
                            <input type="text" name="middle_name" id="middle_name" value="" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name">
                                Last Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" name="last_name" id="last_name" value="" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row my-4">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">
                                Email
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="email" name="email" id="email" class="form-control" value="" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">
                                Phone Number
                                <sup class="text-danger">*</sup>
                            </label>
                            <input value="" type="text" name="phone" id="phone_number" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    @if(adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin())
                        <input type="hidden" name="role" class="d-none" value="{{App\Models\Role::MEMBER}}" />
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">
                                    Role
                                </label>
                                <select name="role" id="role" class="form-control">
                                    @foreach (\App\Models\Role::$roles as $index => $role)
                                        <option value="{{ $index }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gotra">Gotra
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" value="" name="gatra" id="gotra" class="form-control" />
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gotra">Role
                                    <sup class="text-danger">*</sup>
                                </label>
                                @foreach(\App\Models\Role::$roles as $key => $role)
                                    @continue(in_array($key,array_merge(\App\Models\Role::CENTER_USER_ADD_LIST,\App\Models\Role::ADMIN_DASHBOARD_ACCESS,[\App\Models\Role::CENTER])))
                                    <option value="{{$key}}" @if($key == \App\Models\Role::MEMBER) selected @endif>{{$role}}</option>
                                @endforeach
                                <input type="text" value="" name="gatra" id="gotra" class="form-control" />
                            </div>
                        </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">
                                Country
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="country" id="country" class="form-control">
                                @foreach (\App\Models\Country::cursor() as $country)
                                    <option value="{{ $country->getKey() }}" @if($country->getKey() == 153) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">
                                City / State
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" name="city" value="" id="city" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="street_address">
                                Street Address
                                <sup class="text-danger">*</sup>
                            </label>
                            <textarea name="street_address" id="street_address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_birth">
                                Date of Birth
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="place_of_birth">
                                Place of Birth
                            </label>
                            <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button @if(isset($program) && $program) data-bs-target="#assignStudentToProgram" data-bs-toggle="modal" @endif class="btn btn-primary" type="button">Create New Account</button>
                    </div>
                </div>
            </div>
        </div>
        @if( isset($program) && $program )
            <x-modal modal="assignStudentToProgram">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Program Assignment <span class="text-danger">`{{$program->program_name}}`</span>
                    </h3>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="program_section">
                                    Section Enrolment
                                    <sup class="text-danger">*</sup>
                                </label>
                                <select class="form-control no-select-2" name="sections" id="section">
                                    <option value="">Select Section </option>
                                    @foreach ($program->sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->section_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="program_section">
                                    Select Batch Enrolment
                                    <sup class="text-danger">*</sup>
                                </label>
                                <select class="form-control no-select-2" name="current_batch" id="batch">
                                    <option value="">Select Batch</option>
                                    @foreach ($program->programBatches ?? [] as $batch)
                                        <option value="{{ $batch->getKey() }}"> {{ $batch->batch_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <button data-bs-dismiss="modal" type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </x-modal>
        @endif
    </form>

@endsection
