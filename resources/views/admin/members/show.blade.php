@extends("layouts.portal.app")

@section("page_title")
::Profile :: {{ $member->full_name }}
@endsection

@section("content")
<!-- Main Content -->

<section class="content profile-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Profile :: {{ $member->full_name }}</h2>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right padding-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin_dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.members.all') }}">Users</a></li>
                        <li class="breadcrumb-item active">{{ $member->full_name }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card mb-0">
                    <div class="body bg-dark profile-header">
                        <div class="row">
                            <div class="col-lg-10 col-md-12">
                                @if($member->profileUrl)
                                <img src="{{ $member->profileUrl->avatar }}" class="user_pic rounded img-raised" alt="User">
                                @endif
                                <div class="detail">
                                    <div class="u_name">
                                        <h4><strong>{{ $member->first_name }}</strong> {{ $member->last_name }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 user_earnings">
                                <h6>
                                    <br />
                                </h6>
                                <h4><small class="number"></small>
                                    <br />
                                </h4>
                                <span> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="overview">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Info</strong></h2>
                                </div>
                                <div class="body">
                                    <small class="text-muted">Address: </small>
                                    <p>
                                        @if($member->country)
                                        {{ $member->countries->name }}
                                        @endif
                                        @if($member->city)
                                        {{ $member->city }}
                                        @endif
                                        @if($member->address)
                                        {{ $member->address->street_address }}
                                        @endif

                                    </p>
                                    <hr>
                                    <small class="text-muted">Email address: </small>
                                    <p>{{ $member->email }}</p>
                                    <hr>
                                    <small class="text-muted">Phone: </small>
                                    <p>{{ $member->phone_number }}</p>
                                    <hr>
                                    <small class="text-muted">Birth Date: </small>
                                    <p class="m-b-0">{{ ($member->meta && $member->meta->personal && $member->meta->personal->date_of_birth) ? $member->meta->personal->date_of_birth : "XXXX-XX-XX"  }}</p>
                                    <hr>
                                    <small class="text-muted">Birth Place: </small>
                                    <p class="m-b-0">{{ ($member->meta && $member->meta->personal && $member->meta->personal->place_of_birth) ? $member->meta->personal->place_of_birth : "Unknown"  }}</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Education</strong> </h2>
                                </div>
                                <div class="body">
                                    <ul class="follow_us list-unstyled m-b-0">
                                        <li class="online">
                                            <a href="javascript:void(0);">
                                                <div class="media">
                                                    <img class="media-object " src="assets/images/xs/avatar4.jpg" alt="">
                                                    <div class="media-body">
                                                        <span class="name">{{ ($member->meta && $member->meta->education && $member->meta->education->education) ? $member->meta->education->education : ""  }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Account Settings</strong> </h2>
                                </div>
                                <div class="body">
                                    <ul class="follow_us list-unstyled m-b-0">
                                        <li class="online">
                                            <a href="javascript:void(0);">
                                                <div class="media">
                                                    <img class="media-object " src="assets/images/xs/avatar4.jpg" alt="">
                                                    <div class="media-body">
                                                        <span class="name">{{ ($member->meta && $member->meta->education && $member->meta->education->education) ? $member->meta->education->education : ""  }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <x-alert></x-alert>
                            <div class="card">
                                <div class="body m-b-10">
                                    <h3>
                                        Emergency Contact Detail
                                    </h3>

                                    @foreach ($member->emergency_contact as $em_contact)
                                    <form action="{{ route('admin.members.admin_update_for_program',[$member->id,$em_contact->id]) }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Contact Person
                                                    </b>
                                                    <input type="text" name="contact_person" value="{{ $em_contact->contact_person }}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Relation
                                                    </b>
                                                    <input type="text" name="relation" value="{{ $em_contact->relation }}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Phone Number
                                                    </b>
                                                    <input type="text" name="phone_number" value="{{ $em_contact->phone_number }}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Email
                                                    </b>
                                                    <input type="text" name="email_address" value="{{ $em_contact->email_address }}" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary">
                                                    Update Emergency
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr />
                                    @endforeach
                                </div>
                                <div class="body">
                                    <form action="{{ route('admin.members.admin_update_member_basic_info',$member->id) }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <b>
                                                        First Name
                                                    </b>
                                                    <input type="text" name="first_name" id="first_name" value="{{ $member->first_name }}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <b>
                                                        Middle Name
                                                    </b>
                                                    <input type="text" name="middle_name" id="middle_name" value="{{ $member->middle_name }}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <b>
                                                        Last Name
                                                    </b>
                                                    <input type="text" name="last_name" id="last_name" value="{{ $member->last_name }}" class="form-control" />
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        Email
                                                    </b>
                                                    <input type="email" name="email" id="email" class="form-control" value="{{ $member->email }}" />
                                                    @if($member->is_email_verified)
                                                    <span class="text-success">
                                                        Verified
                                                    </span>
                                                    @else
                                                    <span class="text-warning">
                                                        Unverified (<a href="">send verification link</a>)
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        Phone Number
                                                    </b>
                                                    <input value="{{ old('phone_number',$member->phone_number) }}" type="text" name="phone_number" id="phone_number" class="form-control">
                                                    @if($member->is_phone_verified)
                                                    <span class="text-success">
                                                        Verified
                                                    </span>
                                                    @else
                                                    <span class="text-warning">
                                                        Unverified
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Role
                                                    </b>
                                                    <select name="role" id="role" class="form-control">
                                                        @foreach (\App\Models\Role::$roles as $index => $role)
                                                        <option value="{{ $index }}" @if($index==$member->role_id) selected @endif>{{ $role }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        Country
                                                    </b>
                                                    <select name="country" id="country" class="form-control">
                                                        @foreach (\App\Models\Country::cursor() as $country)
                                                        <option value="{{ $country->id }}" @if($country->id == $member->country) selected @endif>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        City / State
                                                    </b>
                                                    <input type="text" name="city" value="{{ $member->city }}" id="city" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Street Addrees
                                                    </b>
                                                    <textarea name="street_address" id="street_address" class="form-control">{{ ($member->address && $member->address->street_address) ? $member->address->street_address : "" }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row bg-light">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Update Information</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="body mt-3">
                                    @if($member->meta)
                                    <form action="{{ route('admin.members.admin_update_member_meta_info',[$member->id, $member->meta->id]) }}" method="post">
                                        Member Meta information
                                    </form>
                                    @else
                                    <form action="{{ route('admin.members.admin_update_member_meta_info',[$member->id]) }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Date of Birth
                                                    </b>
                                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ ($member->meta && $member->meta->personal && $member->meta->personal->date_of_birth) ? $member->meta->personal->date_of_birth : '' }}" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Place of Birth
                                                    </b>
                                                    <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" value="{{ ($member->meta && $member->meta->personal && $member->meta->personal->place_of_birth) ? $member->meta->personal->place_of_birth : null }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <b>
                                                    Gender
                                                </b>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="male" @if(($member->meta && $member->meta->personal && $member->meta->personal->gender) && $member->meta->personal->gender == "male") selected @endif>Male</option>
                                                    <option value="female" @if(($member->meta && $member->meta->personal && $member->meta->personal->gender) && $member->meta->personal->gender == "female") selected @endif>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        Education
                                                    </b>
                                                    <select name="education" id="education" class="form-control">
                                                        <option value="primary" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="primary" ) selected @endif>Primary</option>
                                                        <option value="secondary" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="secondary" ) selected @endif>Secondary (1-20 Class)</option>
                                                        <option value="higher_secondary" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="higher_secondary" ) selected @endif>Higher Secondary (11 - 12 Class)</option>
                                                        <option value="bachelor" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="bachelor" ) selected @endif>Bachelor</option>
                                                        <option value="master" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="master" ) selected @endif>Masters</option>
                                                        <option value="phd" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="phd" ) selected @endif>PhD</option>
                                                        <option value="none" @if(($member->meta && $member->meta->education && $member->meta->education->education) && $member->meta->education->education =="none" ) selected @endif>None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <b>
                                                        Education Major
                                                    </b>
                                                    <input type="text" value="{{ ($member->meta && $member->meta->education && $member->meta->education->education_major) ? $member->meta->education->education_major : null }}" name="education_major" id="form-control" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <b>
                                                        Profession
                                                    </b>
                                                    <input value="{{ ($member->meta && $member->meta->education && $member->meta->education->profession) ? $member->meta->education->profession : null }}" type="text" name="profession" id="profession" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row footer bg-light">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="body">
                                            <h3>
                                                Account Setting(s)
                                            </h3>
                                            <form action="" onsubmit="return confirm('You are about to change the password for current user. Are you sure? this action cannot be undone')" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <strong>
                                                                New Password
                                                                <sup class="text-danger">*</sup>
                                                            </strong>
                                                            <input type="password" name="user_new_password" id="user_new_passowrd" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <strong>
                                                                Confirm Password
                                                                <sup class="text-danger">*</sup>
                                                            </strong>
                                                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary disabled" disabled>
                                                            Change User password
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="body">
                                            <h3>
                                                Enrolled Program Detail
                                            </h3>
                                            <a href="#" data-toggle='modal' data-target='#add_user_to_program' class="btn btn-success btn-sm">
                                                Add user to program
                                            </a>
                                            <table class="table table-hover table-border">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>
                                                            Program Name
                                                        </th>
                                                        <th>
                                                            Enrolled Date
                                                        </th>
                                                        <th>

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($member->member_detail as $member_program)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $member_program->program->program_name }}
                                                        </td>
                                                        <td>
                                                            {{ $member_program->created_at }}
                                                        </td>
                                                        <td>
                                                            <form onsubmit=" return confirm('Are you sure you want remove this user from program. If there are any active transaction for his user in the program you must first remove transaction')" action="{{ route('admin.program.enroll.admin_remove_student_from_program',$member_program->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" href="" class="btn btn-danger btn-small">Remove</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Member not enrolled in any program.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="body">
                                            <h3>
                                                Donation History
                                            </h3>
                                            <table class="table table-hover table-bordred">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            S.No
                                                        </th>
                                                        <th>
                                                            Donation Amount
                                                        </th>
                                                        <th>
                                                            Source
                                                        </th>
                                                        <th>
                                                            Date
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($member->donations as $member_donation)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $member_donation->amount }}
                                                        </td>
                                                        <td>
                                                            {{ $member_donation->type }}
                                                        </td>
                                                        <td>
                                                            {{ $member_donation->created_at }}
                                                        </td>
                                                        <td>
                                                            Remarks
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td class="text-center" colspan="4">
                                                            Donation not available
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Payment
                                        <strong>
                                            History
                                        </strong>
                                    </h2>
                                </div>
                                <div class="body">
                                    <table class="table-border table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Program Name
                                                </th>
                                                <th>
                                                    Transaction Amount
                                                </th>
                                                <th>
                                                    Source
                                                </th>
                                                <th>
                                                    Status
                                                </th>

                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($member->transactions as $transaction)
                                            <tr>
                                                <td>
                                                    {{ $transaction->program->program_name }}
                                                </td>
                                                <td>
                                                    {{ ($transaction->source) }}
                                                    <br />
                                                    {{ $transaction->source_detail }}
                                                </td>
                                                <td>
                                                    @if($transaction->rejected)
                                                    <span class="badge bg-danger px-2">
                                                        <a href="#" title="Rejected">
                                                            <i class="text-white zmdi zmdi-minus-circle-outline"></i>
                                                        </a>
                                                    </span>
                                                    @elseif ( ! $transaction->verified)
                                                    <span class="badge bg-warning px-2">
                                                        <a href="#" title="Unverified">
                                                            <i class="text-white zmdi zmdi-minus-circle-outline"></i>
                                                        </a>
                                                    </span>
                                                    @else
                                                    <span class="badge bg-success px-2"><a href="#" title="Verified"><i class="text-white zmdi zmdi-check"></i></a></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->source == 'online')
                                                    @foreach ($transaction->remarks as $key => $remarks)
                                                    <strong>
                                                        {{ $key }} :
                                                    </strong>
                                                    {{ $remarks }}
                                                    <br />
                                                    @endforeach
                                                    @elseif($transaction->source == 'Voucher Upload')
                                                    Date : {{ $transaction->remarks->upload_date }}
                                                    @if($transaction->file && isset($transaction->file->path))
                                                    <br />
                                                    [<a data-target="#imageFile" data-toggle="modal" href="{{ route('admin.program.fee.admin_display_fee_voucher', $transaction->id) }}">View File</a>]
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <form style='display:inline' method='post' class='transaction_action_form' action="{{ route('admin.program.fee.api_update_fee_detail', [$transaction->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type='hidden' name='update_type' value='status' />
                                                        @if ($transaction->verified)
                                                        <button type='submit' class='btn btn-danger btn-sm'>Reject</button>
                                                        @else
                                                        <button type='submit' class='btn btn-success btn-sm'>Verify</button>
                                                        @endif
                                                    </form>

                                                    <form style='display:inline' method='post' action="{{ route('admin.program.fee.api_delete_fee', $transaction->id) }}" class='transaction_delete_form'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type='hidden' name='update_type' value='status' />
                                                        <button type='submit' class='btn btn-danger btn-sm'><i class='zmdi zmdi-delete'></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    Payment not found.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<x-modal modal='add_user_to_program'>
    <div class="modal-header">
        <h3 class="modal-header">
            Link program
            {{ route('admin.program.admin_modal_program_meta_information',2) }}
        </h3>
    </div>

    <div class="modal-body">
        <form action="{{ route('admin.program.enroll.admin_student_enroll_in_program',$member->id) }}" method="post" id="assign_program_to_user">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="program_name">Program Name</label>
                        <select name="program_name" id="program_name" class="form-control">
                            <option value="" selected>Select option</option>
                            <sup class="text-danger">*</sup>
                            @foreach (\App\Models\Program::get() as $program)
                            <option value="{{$program->id}}">
                                {{ $program->program_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="appendElements">
                <p>
                    Please select program to select batch and section.
                </p>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Enroll Student In Program</button>
                </div>
            </div>
        </form>
    </div>
</x-modal>

<x-modal modal="imageFile">
    <div class="modal-header">
        <button type="button" style="z-index:999" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
    <div class="modal-body" id='imageContent'>
        <p class="text-center">
            Please wait.. loading image.
        </p>
    </div>
</x-modal>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>

<script type="text/javascript">
    $("#program_name").change(function() {
        if ($(this).find(':selected').val() != "") {
            let parentNode = $(this).closest('form');
            $("#appendElements").empty()
            $.ajax({
                method: "GET",
                url: "/admin/programs/program/store/" + $(this).find(':selected').val(),
                success: function(response) {
                    $("#appendElements").append(response);
                }
            })
        }
    });

    $("#imageFile").on("shown.bs.modal", function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.href,
            success: function(response) {
                $("#imageContent").html(response);
            }
        })
    });

    $(document).on("click", ".transaction_action", function(event) {
        event.preventDefault();
        var confirm_action = confirm("You are about to change current status of transaction. Are you sure ?");
        let cur_elem = $(this);
        $(cur_elem).find('button').prop('disabled', true);
        $.ajax({
            url: $(this).attr("href"),
            success: function(response) {
                window.location.reload();
            },
            error: function() {
                alert('Unable to update transaction detail');
                $(cur_elem).find('button').prop('disabled', false);

            }
        })
    })
    $(document).on('submit', '.transaction_action_form', function(event) {
        event.preventDefault();
        // alert("prevented.");
        $.ajax({
            type: $(this).attr('method'),
            data: $(this).serializeArray(),
            url: $(this).attr("action"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                window.location.reload();
            }

        })
    })
    $(document).on("click", '.transaction_delete_form', function(event) {
        event.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            data: $(this).serializeArray(),
            url: $(this).attr('action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                window.location.reload();
            }
        })

    });
</script>
@endsection