@extends('layouts.admin.master')
@push('page_title') Settings @endpush
@section('main')
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Website/</span> Settings
            </h4>
        </div>
    </div>
    <form action="{{ route('admin.website.settings.admin_website_update_settings') }}" enctype="multipart/form-data" method="post" class="ajax-form">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2><strong>Logo</strong> Settings </h2>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8 border-right border-primary">
                                <div class="form-group">
                                    <strong>Main Logo
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="file" name="main_logo" id="main_logo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <strong>Current Logo</strong>
                                <img src="{{ asset($settings->where('name','logo')->first()->value) }}" class="" />
                            </div>
                        </div>
                        <div class="row mt-3 border-top border-primary align-items-center">
                            <div class="col-md-8 mt-3 border-right border-primary">
                                <div class="form-group">
                                    <strong>Favicon
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="file" name="favicon" id="favicon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <strong>Current Favicon</strong>
                                <img src="{{ asset($settings->where('name','favicon')->first()->value) }}" class="" />
                            </div>
                        </div>

                        @if($settings->where('name','loading_bar')->first()->value)
                            <div class="row mt-3 border-top border-primary align-items-center">
                                <div class="col-md-8 mt-3 border-right border-primary">
                                    <div class="form-group">
                                        <strong>Loading Bar / Image
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="file" name="loading_bar_image" id="favicon">
                                    </div>
                                </div>
                                <div class="col-md-4 bg-grey">
                                    <strong>Current Loading Image</strong>
                                    <img src="{{ asset($settings->where('name','loading_bar_image')->first()->value) }}" class="" />
                                </div>
                            </div>

                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class='btn btn-primary'>
                                    Update Site Logo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($settings->where('name','online_payment')->first()->value)
                    <div class="card mt-1">
                        <div class="card-header">
                            <h5>Payment API Integration </h5>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <strong>General</strong> Settings
                        </h2>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-check form-check-primary mt-4">
                                        <label class="form-check-label" for="loading">Enable Loading</label>
                                        <input class="form-check-input" type="checkbox" name="loading" value="1" id="loading" @if($settings->where('name','loading_bar')->first()->value) checked @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-check form-check-primary mt-4">
                                        <label class="form-check-label" for="cache">Site Cache</label>
                                        <input class="form-check-input" type="checkbox" name="cache" value="1" id="cache" @if($settings->where('name','cache')->first()->value) checked @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-check form-check-primary mt-4">
                                        <label class="form-check-label" for="donation">Donation</label>
                                        <input class="form-check-input" type="checkbox" name="donation" value="1" id="donation"  @if($settings->where('name','donation')->first()->value) checked @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-check form-check-primary mt-4">
                                        <label class="form-check-label" for="online_payment">Online Payment</label>
                                        <input class="form-check-input" type="checkbox" name="online_payment" value="1" id="online_payment" @if($settings->where('name','online_payment')->first()->value) checked @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-check form-check-primary mt-4">
                                        <label class="form-check-label" for="live_button">Live Button</label>
                                        <input class="form-check-input live_show" type="checkbox" name="live_show" value="1" id="live_button" @if($settings->where('name','live_show')->first()->value) checked @endif>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Theme</strong>
                                    <input type="text" name="theme" value="Siddhamahayog-OM" class="form-control" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <strong>Website URL</strong>
                                    <input type="text" name="website_url" value="{{ $settings->where('name','website_url')->first()->value }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <strong>Website Name</strong>
                                    <input type="text" name="website_name" value="{{ $settings->where('name','website_name')->first()->value }}" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Official Email
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="email" value="{{$settings->where('name','official_email')->first()->value}}" name="official_email" id="official_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Company Address
                                    </strong>
                                    <textarea name="company_address" id="company_address" class="form-control">{{$settings->where('name','company_address')->first()->value}}</textarea>
                                </div>
                            </div>


                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Unpaid Account Access Days</strong>
                                    <input type="text" name="unpaid_access" value="{{ $settings->where('name','unpaid_access')->first()->value }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    Update WebSetting
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection
