@extends('layouts.admin.master')
@push('page_title')Login::Authetication Required @endpush
@push('page_css')
    <link rel="stylesheet" href="{{asset('themes/admin/assets/vendor/css/pages/page-auth.css')}}">
@endpush

@section('main')
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4 mt-2">
              <a href="index.html" class="app-brand-link">
                <span class="app-brand-logo demo">
                        <img src="{{site_settings('logo')}}" alt="" class="src img-fluid" style="width:55px;">
                </span>
                <span class="app-brand-text demo text-body fw-bold">{{site_settings('website_name')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1 pt-2">Welcome to {{site_settings('website_name')}} 👋</h4>
            <p class="mb-4">Please sign-in to your account to continue</p>
  
            <form class="mb-3 ajax-form-login" action="{{route('admin.users.auth')}}" enc="{{substr(config('app.key'),7)}}" method="post">
              <div class="mb-3">
                <div class="form-group">
                    <label for="email" class="form-label">Email
                        <sup class="text-danger">*</sup>
                    </label>
                    <input value="" type="email" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus>
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                      <label class="form-label" for="password">Password</label>
                      <a href="auth-forgot-password-basic.html">
                        <small>Forgot Password?</small>
                      </a>
                    </div>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" name="remember_me" type="checkbox" id="remember-me">
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  
@endsection