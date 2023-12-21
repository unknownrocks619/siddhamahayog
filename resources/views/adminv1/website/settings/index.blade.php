@extends("layouts.portal.app")

@section("page_title")
Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Programs</h2>
                    <small>
                        <a href="{{ route('admin.program.admin_program_new') }}">[Create New Batch]</a>
                    </small>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
        <form action="{{ route('admin.website.settings.admin_website_update_settings') }}" enctype="multipart/form-data" method="post">

            <div class="row clearfix">
                <div class="col-lg-6">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Logo</strong> Settings </h2>
                        </div>
                        <div class="body">
                            <div class="row">
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
                            <div class="row mt-3 border-top border-primary">
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
                            <div class="row mt-3 border-top border-primary">
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
                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class='btn btn-sm btn-info'>
                                        Update Site Logo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>General</strong> Settings
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Loading</strong> Bar
                                        <input name="loading" value="1" type="checkbox" @if($settings->where('name','loading_bar')->first()->value) checked @endif data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Site Cache</strong>
                                        <input name="cache" value="1" type="checkbox" @if($settings->where('name','cache')->first()->value) checked @endif data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Donation</strong>
                                        <input name="donation" value="1" type="checkbox" @if($settings->where('name','donation')->first()->value) checked @endif data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Online Payment</strong>
                                        <input name="online_payment" value="1" type="checkbox" @if($settings->where('name','online_payment')->first()->value) checked @endif data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Live Button</strong>
                                        <input name="live_show" value="1" type="checkbox" @if($settings->where('name','live_show')->first()->value) checked @endif data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Theme</strong>
                                        <input type="text" name="theme" value="Siddhamahayog-OM" class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Website URL</strong>
                                        <input type="text" name="website_url" value="{{ $settings->where('name','website_url')->first()->value }}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Website Name</strong>
                                        <input type="text" name="website_name" value="{{ $settings->where('name','website_name')->first()->value }}" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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
                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Update WebSetting
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <div class="moda-body">
                <p>Please wait...loading your data</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

@endsection