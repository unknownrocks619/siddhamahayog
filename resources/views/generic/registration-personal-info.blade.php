<div class="card">
    <div class="card-body">
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
                    <input type="email" value="" name="email" id="email" class="form-control"
                        value="" />
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
            <div class="col-md-6">
                <div class="form-group">
                    <label for="country">
                        Country
                        <sup class="text-danger">*</sup>
                    </label>
                    <select name="country" id="country" class="form-control">
                        @foreach (\App\Models\Country::cursor() as $country)
                            <option value="{{ $country->getKey() }}" @if ($country->getKey() == 153) selected @endif>
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
                    <input type="password" name="password_confirmation" id="confirm_password"
                        class="form-control" />
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary">Create New Account</button>
                <a href="" class="btn btn-text btn-primary">Restart Process</a>
            </div>
        </div>
    </div>
</div>
