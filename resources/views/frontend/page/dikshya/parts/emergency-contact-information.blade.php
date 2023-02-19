<div class="row mb-2">
    <div class="col-md-12">
        <h4 class="theme-text">
            Emergency Contact Information
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="contact_person">Emergency Contact Person
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" name="emergency_contact_person"
                value="{{ $user_record['emmergency_contact_name'] ?? old('emergency_contact_person') }}"
                id="contact_person"
                class="form-control @error('emergency_contact_person') border border-danger @enderror" />
            @error('emergency_contact_person')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="emergency_phone">Contact Mobile Number
                <sup class="text-danger">
                    *
                </sup>
            </label>
            <input type="text" value="{{ $user_record['emmergency_contact_number'] ?? old('emergency_phone') }}"
                name="emergency_phone" id="emergency_phone" value=""
                class="form-control @error('emergency_phone') border border-danger @enderror">
            @error('emergency_phone')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mt-1">
        <div class="form-group">
            <label for="emergency_contact_person_relation">Relation to Emergency Contact
                Person
                <sup class="text-danger">*</sup>
            </label>
            <input value="{{ $user_record['emmergency_contact_relation'] ?? old('emergency_contact_person_relation') }}"
                type="text" name="emergency_contact_person_relation" id="emergency_contact_person_relation"
                class="form-control @error('emergency_contact_person_relation') border border-danger @enderror">
            @error('emergency_contact_person_relation')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
