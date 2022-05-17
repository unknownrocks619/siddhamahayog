@extends("layouts.portal.app")

@section("page_title")
    Add New Member
@endsection

@section("page_css")
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Add New Member</h2> 
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <x-alert></x-alert>
                <form action="{{ route('admin.members.admin_store_member_to_program',$program->id) }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Member</strong> Registration </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button" onclick="window.location.href='{{route('admin.program.admin_program_detail',[$program->id])}}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            First Name
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="text" value="{{ old('first_name') }}" name="first_name" id="first_name" class="form-control" />
                                        @error("first_name")
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Middle Name
                                        </strong>
                                        <input value="{{ old('middle_name') }}" type="text" name="middle_name" id="middle_name" class="form-control" />
                                        @error("middle_name")
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Last Name
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input value="{{ old('last_name') }}" type="text" name="last_name" id="last_name" class="form-control" />
                                        @error("last_name")
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Source
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input value="{{ old('source','admin') }}" type="text" readonly name="source" id="source" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Profile Picture
                                        </strong>
                                        <input  type="file" name="profile" id="profile" class="form-control" />
                                        @error("profile")
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Email
                                            <sup class='text-danger'>*</sup>
                                        </strong>
                                        <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control" />
                                        @error("email")
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Phone
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="text" name="phone" id="phone" class="form-control" />
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Password
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input value="{{ old('password') }}" type="password" name="password" id="password" class="form-control" />
                                        @error("password")
                                            <div class='text-danger'>{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Confirm Password
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" />
                                        @error("confirm_password")
                                            <div class="text-danger">{{$message}}</div>                                        
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Student Type
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <select name="student_type" id="student_type" class="form-control form-select">
                                            <option value='general' @if(old('student_type') == "general") selected @endif>General</option>
                                            <option value='scholar' @if(old('student_type') == "scholar" ) selected @endif>Full Scholarship</option>
                                            <option value='scholar_month' @if(old('student_type') == "scholar_month") selected @endif>Scholarsip on Month</option>
                                            <option value='scholar_admission' @if(old('student_type') == "scholar_admission") selected @endif>Scholarsip on Admission</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Program
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input readonly type="text" name="program" id="program" class="form-control" value="{{ old('program',$program->program_name) }}" class="form-group" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Batch
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <select name="current_batch" id="batch" class="form-control">
                                            @foreach ($batches as $bat)
                                                <option value="{{$bat->batch->id}}" @if(old('current_batch') == $bat->batch->id) selected @endif>{{$bat->batch->batch_name}} ({{ $bat->batch->batch_year }}-{{ $bat->batch->batch_month }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Section
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </strong>
                                        <select name="sections" id="sectons" class="form-control">
                                            @foreach ($sections as $section)
                                                <option @if($section->id == old('sections')) selected @endif value='{{ $section->id }}'>{{ $section->section_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Admission Fee Voucher
                                        </strong>
                                        <input type="file" name="fee_voucher" id="fee_voucher" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-block btn-primary">Register Member</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
@endsection