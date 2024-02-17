
<!-- Project table -->
<form class="ajax-form" action="{{ route('admin.members.admin_update_member_basic_info',$member->id) }}" method="post">
    <div class="card mb-4">
        <h5 class="card-header">{{ $member->full_name }} Account Information</h5>
        <div class="card-body">

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

            <div class="row my-2 mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <b>
                            Email
                        </b>
                        <input @if( ! adminUser()->role()->isSuperAdmin() ) disabled @endif type="email" name="email" id="email" class="form-control" value="{{ $member->email }}" />
                        @if($member->is_email_verified)
                            <span class="text-success mt-2">
                                                            Verified
                                                        </span>
                        @else
                            <span class="text-warning mt-2">
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
                            <span class="text- mt-2">
                                                            Verified
                                                        </span>
                        @else
                            <span class="text-warning mt-2">
                                                            Unverified
                                                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row my-2 mt-4">
                @if( adminUser()->role()->isAdmin() || adminUser()->role()->isSuperAdmin() )
                    <div class="col-md-6">
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
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gotra">Gotra</label>
                        <input type="text" value="{{$member->gotra}}" name="gatra" id="gotra" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row my-2 mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <b>
                            Country
                        </b>
                        <select name="country" id="country" class="form-control">
                            @foreach (\App\Models\Country::cursor() as $country)
                                <option value="{{ $country->id }}" @if($country->id == $member->country) selected @elseif($country->id == 153) selected @endif>{{ $country->name }}</option>
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

            <div class="row mt-2 mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <b>
                            Street Address
                        </b>
                        <textarea name="street_address" id="street_address" class="form-control">{{ ($member->address && $member->address->street_address) ? $member->address->street_address : "" }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <b>
                            Date of Birth
                        </b>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ ($member->meta && $member->meta->personal && $member->meta->personal->date_of_birth) ? $member->meta->personal->date_of_birth : '' }}" class="form-control" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <b>
                            Place of Birth
                        </b>
                        <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" value="{{ ($member->meta && $member->meta->personal && $member->meta->personal->place_of_birth) ? $member->meta->personal->place_of_birth : null }}" />
                    </div>
                </div>
            </div>

            <div class="row mt-2 mt-4">
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

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <b>
                            Profession
                        </b>
                        <input value="{{ ($member->meta && $member->meta->education && $member->meta->education->profession) ? $member->meta->education->profession : null }}" type="text" name="profession" id="profession" class="form-control" />
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">
                    Update Personal Detail
                </button>
            </div>
        </div>
    </div>
</form>
<!-- /Project table -->
