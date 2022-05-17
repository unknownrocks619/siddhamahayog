@extends("layouts.portal.app")

@section("page_title")
    - Zoom Accounts - Setup Account
@endsection

@section("top_css")
    <link href="{{ asset ('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Zoom Account</h2>                    
                </div>            
                <!-- <div class="col-lg-7 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Basic Elements</li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.admin_zoom_acount_store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> Zoom Account </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button" onclick="window.location.href='{{ route('admin.admin_zoom_account_show') }}'" class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix mt-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="account_name">Name
                                            <sup class='text-danger'>*</sup>
                                        </b>
                                        <input type="text" class="form-control" name="name" id="account_name" require value="{{ old('name') }}" />
                                        @error("name")
                                            <div class="text-danger">
                                                {{ $message }}                                        
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="account_name">Account Status
                                            <sup class='text-danger'>*</sup>
                                        </b>
                                        <select name="status" id="account_status" class='form-control' required>
                                            <option value="active" selected>Active</option>
                                            <option value="suspend" @if(old('status') == "suspend") selected @endif>Suspend</option>
                                        </select>
                                        @error("status")
                                            <div class="text-danger">
                                                {{ $message }}                                        
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix mt-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="account_username">
                                            Zoom Registered Email
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </b>
                                        <input type="email" value="{{ old('username') }}" name="username" id="" class="input-group form-control">
                                        @error("username")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="category">
                                            Account Access Category
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </b>
                                        <select name="category" id="category" class="form-control">
                                            <option value="admin" selected>Admin</option>
                                            <option value="zone" @if(old('category') =='zone' ) selected @endif>Zonal</option>
                                            <option value="local" @if(old('category') == "local") selected @endif>Local</option>
                                            <option value="other" @if(old('category') == "other") selected @endif>Other</option>
                                        </select>
                                        @error("category")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix mt-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="api_token">
                                            Developer API TOKEN
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <textarea name="api_token" placeholder="paste your token here" id="api_token" cols="30" rows="6" class='form-control'>{{old('api_token')}}</textarea>
                                        @error("api_token ")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer clearfix mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class='btn btn-primary btn-block'>Create Zoom Account</button>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js --> 
<script src="{{ asset ('assets/js/pages/forms/basic-form-elements.js') }}"></script> 

@endsection