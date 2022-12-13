    <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-center">
            <h2 class="theme-text fw-bold">हिमालयन सिद्घमहायोग - वेदान्त दर्शन</h2>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 border-end border-theme">
            @if(site_settings('online_payment') || user()->role_id == 1)
            <form action="{{ route('user.account.programs.payment.create.form',[$program->id]) }}" method="get">
                @else
                <form action="{{ route('dashboard',[$program->id]) }}" method="get">
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="theme-text">
                                Admission Fee
                            </h3>
                        </div>
                    </div>
                    <div class="row mt-4">
                        @if(getUserCountry() != 'NP')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="AdmissionFee">Admission Fee</label>
                                <input type="text" name="admission_fee" id="admission_fee" value="USD 199" class="form-control" />
                            </div>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="AdmissionFee">Admission Fee</label>
                                <input type="text" name="admission_fee" value="NRs 9000" id="admission_fee" class="form-control" />
                                <sup class="text-info">Above price is applicable only for people living in Nepal.</sup>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(getUserCountry() == 'NP')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="paymentOpt" class="mb-2">
                                    Select Payment Method
                                </label>
                                <select name="paymentOpt" id="paymentOpt" class=" form-control @error('regural_medicine_history') border border-danger @enderror">
                                    <option value="esewa">E-Sewa</option>
                                    <option value="voucher">Voucher</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                For More Information<br />
                                Please Contact Your nearest <code>`Mahayogi Siddhababa Spiritual Academy`</code> center.
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row bg-light mt-4">
                        <div class="col-md-12 py-4">
                            <div class="card-footer">
                                @if((site_settings('online_payment') || user()->role_id == 1) && getUserCountry() == "NP")
                                <button type="submit" class="btn btn-danger">
                                    Confirm Payment Method
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
        </div>
        <div class="col-md-6 ps-2">

            <div class="col-md-12">
                <h4 class="theme-text">
                    Other Options
                </h4>
            </div>

            <div class="col-md-12 my-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                    GO TO DASHBOARD
                </a>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4 class="theme-text">
                            Follow Us On
                        </h4>
                    </div>

                    <div class="col-md-12 d-flex justify-content-start">
                        <a href="https://www.facebook.com/siddhamahayog/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="fill: rgba(76, 39, 67, 1);transform: ;msFilter:;">
                                <path d="M20 3H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h8.615v-6.96h-2.338v-2.725h2.338v-2c0-2.325 1.42-3.592 3.5-3.592.699-.002 1.399.034 2.095.107v2.42h-1.435c-1.128 0-1.348.538-1.348 1.325v1.735h2.697l-.35 2.725h-2.348V21H20a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z"></path>
                            </svg>
                        </a>
                        <a class="ms-4" href="https://www.youtube.com/channel/UCtk8uKMJzwuiOwPH9M7p5Tg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="fill: rgba(76, 39, 67, 1);transform: ;msFilter:;">
                                <path d="M21.593 7.203a2.506 2.506 0 0 0-1.762-1.766C18.265 5.007 12 5 12 5s-6.264-.007-7.831.404a2.56 2.56 0 0 0-1.766 1.778c-.413 1.566-.417 4.814-.417 4.814s-.004 3.264.406 4.814c.23.857.905 1.534 1.763 1.765 1.582.43 7.83.437 7.83.437s6.265.007 7.831-.403a2.515 2.515 0 0 0 1.767-1.763c.414-1.565.417-4.812.417-4.812s.02-3.265-.407-4.831zM9.996 15.005l.005-6 5.207 3.005-5.212 2.995z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>