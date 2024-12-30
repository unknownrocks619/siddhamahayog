@php
    if (!isset($member)) {
        $member = auth('web')->user();
    }

@endphp
<div class="card">
    <div class="card-body">
        <div class="row my-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="first_name">
                        First Name
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" value="{{ $member->first_name }}" name="first_name" id="first_name" class="form-control" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="middle_name">
                        Middle Name
                    </label>
                    <input type="text" value="{{ $member->middle_name }}" name="middle_name" id="middle_name"
                        class="form-control" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="last_name">
                        Last Name
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" value="{{ $member->last_name }}" name="last_name" id="last_name"
                        class="form-control" />
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
                    <input type="email" value="{{ $member->email }}" @if ($member->is_email_verified) disabled @endif
                        name="email" id="email" class="form-control" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_number">
                        Phone Number
                        <sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ $member->phone_number }}" @if ($member->is_phone_verified) disabled @endif
                        type="text" name="phone" id="phone_number" class="form-control">
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
                            <option @if ($member->country == $country->getKey()) selected @endif value="{{ $country->getKey() }}"
                                @if ($country->getKey() == 153) selected @endif>
                                {{ $country->name }}</option>
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
                    <input type="text" value="{{ $member->city }}" name="city" id="city"
                        class="form-control" />
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
                    <textarea name="street_address" id="street_address" class="form-control">{{ $member->address?->street_address }}</textarea>
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
                    <input type="date" value="{{ $member->date_of_birth }}" name="date_of_birth" id="date_of_birth"
                        class="form-control" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="place_of_birth">
                        Place of Birth
                    </label>
                    <input type="text" name="place_of_birth" id="place_of_birth"
                        value="{{ $member->meta?->personal['place_of_birth'] ?? '' }}" class="form-control" />
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
                        <option @if ($member->meta?->personal['gender'] ?? 'male' == 'male') selected @endif value="male">Male</option>
                        <option @if ($member->meta?->personal['gender'] ?? 'male' == 'female') selected @endif value="female">Female</option>
                        <option @if ($member->meta?->personal['gender'] ?? 'other' == 'male') selected @endif value="other">Other</option>
                    </select>
                </div>
            </div>
            @if (!$member->centers?->count())
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="center">Select Nearest Center</label>
                        <select name="center" id="center" class="form-control">
                            @foreach (\App\Models\Centers::cursor() as $center)
                                <option value="{{ $center->getKey() }}">{{ $center->name_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary">Update Information</button>
            </div>
        </div>
    </div>
</div>
