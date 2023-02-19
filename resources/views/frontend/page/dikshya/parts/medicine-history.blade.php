<div class="row sigma_broadcast-video my-3">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">
                    {{ __('sadhana.sadhana_extra_health_heading') }}
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regural_medicine_history" class="mb-4">
                                {{ __('sadhana.sadhana_medicine_history_label') }}
                            </label>
                            <select name="regural_medicine_history" id="regural_medicine_history"
                                class="mt-2 form-control @error('regural_medicine_history') border border-danger @enderror">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mental_health_history">{{ __('sadhana.sadhana_medicine_mental_label') }}
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="mental_health_history" id="mental_health_history"
                                class="form-control @error('mental_health_history') border border-danger @enderror">
                                <option value="no" @if (old('mental_health_history') == 'no') selected @endif>No</option>
                                <option value="yes" @if (old('mental_health_history') == 'yes') selected @endif>Yes</option>
                            </select>
                            @error('mental_health_history')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row  mt-2 d-none" id="regular_health_detail">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="label-control">
                                {{ __('sadhana.sadhana_medicine_history_detail_label') }}
                            </label>
                            <textarea class="form-control @error('regular_medicine_history_detail') border border-danger @enderror"
                                id="regular_medicine_history_detail" name="regular_medicine_history_detail" class="regular_medicine_history_detail">{{ old('regular_medicine_history_detail') }}</textarea>
                            @error('regular_medicine_history_detail')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row d-none mt-2" id="mental_health_hisotry_detail">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="label-control">
                                {{ __('sadhana.sadhana_medicine_mental_detail_label') }}
                            </label>
                            <textarea class="form-control @error('mental_health_detail_problem') border border-danger @enderror"
                                name="mental_health_detail_problem" id="mental_health_detail_problem" class="mental_health_detail_problem">{{ old('mental_health_detail_problem') }}</textarea>
                            @error('mental_health_detail_problem')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row sigma_broadcast-video my-3">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">
                    {{ __('sadhana.sadhana_extra_info_heading') }}
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_person">{{ __('sadhana.sadhana_practiced_history_label') }}
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="practiced_info" id="practiced_info"
                                class="form-control @error('practiced_info') border border-danger @enderror">
                                <option value="no" @if (old('practiced_info') == 'no') selected @endif>No</option>
                                <option value="yes" @if (old('practiced_info') == 'yes') selected @endif>Yes</option>
                            </select>
                            @error('practiced_info')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="support_in_need">{{ __('sadhana.support_ashram_in_need') }}
                                <sup class="text-danger">
                                    *
                                </sup>
                            </label>
                            <select name="support_in_need" id="support_in_need"
                                class="form-control @error('support_in_need') border border-danger @enderror">
                                <option value="yes" @if (old('support_in_need') == 'yes') selected @endif>Yes</option>
                                <option value="no" @if (old('support_in_need') == 'no') selected @endif>No</option>
                            </select>
                            @error('support_in_need')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="row sigma_broadcast-video my-3">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">
                    Membership Info
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="are_you_sadhak">Are you a sadhak ?
                                <sup class="text-danger">*</sup>
                            </label>
                            <select name="user_sadhak" id="user_sadhak"
                                class="form-control @error('user_sadhak') border border-danger @enderror">
                                <option value="no" @if (old('user_sadhak') == 'no') selected @endif>No</option>
                                <option value="yes" @if (old('user_sadhak') == 'yes') selected @endif>Yes</option>
                            </select>
                            @error('user_sadhak')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
