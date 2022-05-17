@extends("layouts.portal.guest")

@section("page_title")
  -Reset Your Password
@endsection

@section("content")
<div class="col-lg-5 col-md-12 offset-lg-1">
                    <div class="card-plain">
                        <div class="header">
                            <h5>Sign Up</h5>
                            <span>Register a new membership</span>
                        </div>
                        <form class="form">                            
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter User Name">
                                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Email">
                                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            </div>
                            <div class="input-group">
                                <input type="password" placeholder="Password" class="form-control" />
                                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            </div>
                            <div class="checkbox">
                                <input id="terms" type="checkbox">
                                <label for="terms">I read and Agree to the <a href="{{ route('terms') }}">Terms of Usage</a></label>
                            </div>                            
                        </form>
                        <div class="footer">
                            <a href="index.html" class="btn btn-primary btn-round btn-block">SIGN UP</a>
                        </div>
                        <a class="link" href="{{ route('login') }}">You already have a membership?</a>
                    </div>
                </div>
@endsection