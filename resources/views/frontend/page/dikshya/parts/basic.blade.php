<div class="row">
    <div class="col-md-12">
        <h4 class="theme-text">
            Basic Information
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="first_name">First Name
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" value="{{ $user_record['first_name'] ?? old('first_name') }}" name="first_name"
                id="first_name" class="mt-2 form-control @error('first_name') border border-danger @enderror" />
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="middle_name">Middle Name
            </label>
            <input type="text" value="{{ $user_record['middle_name'] ?? old('middle_name') }}" name="middle_name"
                id="middle_name" class="mt-2 form-control @error('middle_name') border border-danger @enderror" />
            @error('middle_name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="last_name">Last Name
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" value="{{ $user_record['last_name'] ?? old('last_name') }}" name="last_name"
                id="last_name" class="mt-2 form-control @error('last_name') border border-danger @enderror" />
            @error('last_name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="gender">Gender
                <sup class="text-danger">*</sup>
            </label>
            <select name="gender" id="gender" class="form-control">
                <option value="male" @if ((isset($user_record['gender']) && $user_record['gender'] == 'male') || old('gender') == 'male') selected @endif>
                    Male</option>
                <option value="female" @if ((isset($user_record['gender']) && $user_record['gender'] == 'female') || old('gender') == 'female') selected @endif>
                    Female</option>
            </select>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="phone_number">Mobile Number
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" value="{{ $user_record['phone_number'] ?? old('phone_number') }}" name="phone_number"
                id="phone_number" class="form-control @error('phone_number') border border-danger @enderror">
            @error('phone_number')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4 mt-2">
        <div class="form-group">
            <label for="country">
                Country
                <sup class="text-danger">*</sup>
            </label>
            <select name="country" id="country" class="form-control">
                <?php
                $countries = \App\Models\Country::get();
                ?>
                @foreach ($countries as $country)
                    <option value="{{ $country->getKey() }}"
                        @if (
                            (isset($user_record['country']) && $user_record['country'] == $country->getKey()) ||
                                old('country') == $country->getKey()) selected @elseif($country->getKey() == 153) selected @endif>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            @error('country')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mt-2">
        <div class="form-group">
            <label for="state">
                State
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" value="{{ $user_record['state'] ?? old('state') }}" name="state" id="state"
                class="form-control">
        </div>
    </div>
    <div class="col-md-4 mt-2">
        <div class="form-group"><label for="address">Street Address</label>
            <textarea name="street_address" id="street_address" style="resize: none;"
                class="form-control @error('street_address') border border-danger @enderror">{{ $user_record['street_address'] ?? old('street_address') }}</textarea>

        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="date_of_birth">
                Date of Birth
            </label>
            <input type="date" value="{{ $user_record['date_of_birth'] ?? old('date_of_birth') }}"
                name="date_of_birth" id="date_of_birth"
                class="form-control @error('date_of_birth') border border-danger @enderror" />
            @error('date_of_birth')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="date_of_birth">
                Place of Birth
            </label>
            <input type="text" name="place_of_birth"
                value="{{ $user_record['place_of_birth'] ?? old('place_of_birth') }}" id="place_of_birth"
                class="form-control @error('place_of_birth') border border-danger @enderror" />
            @error('place_of_birth')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="education">Your Highest Education
                <sup class="text-danger">*</sup>
            </label>
            <select name="education" id="education"
                class="form-control @error('education') border border-danger @enderror">
                <option value="primary" @if ((isset($user_record['education']) && $user_record['education'] == 'primary') || old('education') == 'primary') selected @endif>
                    Primary</option>
                <option value="secondary" @if ((isset($user_record['education']) && $user_record['education'] == 'secondary') || old('education' == 'primary')) selected @endif>Secondary (1-20 Class)
                </option>
                <option value="higher_secondary" @if (isset($user_record['higher_secondary']) && $user_record['education'] == 'primary') selected @endif>Higher Secondary
                    (11
                    -
                    12 Class)</option>
                <option value="bachelor" @if (isset($user_record['education']) && $user_record['education'] == 'bachelor') selected @endif>
                    Bachelor</option>
                <option value="master" @if (isset($user_record['education']) && $user_record['education'] == 'master') selected @endif>
                    Masters</option>
                <option value="phd" @if (isset($user_record['education']) && $user_record['education'] == 'phd') selected @endif>
                    PhD</option>
                <option value="none" @if (isset($user_record['education']) && $user_record['education'] == 'none') selected @endif>
                    None</option>
            </select>
            @error('education')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <label for="profession">Profession
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" name="profession" value="{{ $user_record['profession'] ?? old('profession') }}"
                id="profession" class="form-control @error('profession') border border-danger @enderror">

            @error('profession')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-col-md-6">
        <div class="form-group">
            <label for="field_of_study">
                What is your education major ?
                <small class="text-info">
                    Please be as specific as possible (example: computer science,
                    engineering etc.)
                </small>
            </label>
            <input value="{{ $user_record['education_major'] ?? old('field_of_study') }}" type="text"
                name="field_of_study" id="field_of_study"
                class="form-control @error('field_of_study') border border-danger @enderror">
            @error('field_of_study')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
