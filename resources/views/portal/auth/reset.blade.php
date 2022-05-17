@extends("layouts.portal.guest")

@section("page_title")
  -Reset Your Password
@endsection

@section("content")
    <div class="col-lg-5 col-md-12 offset-lg-1">
        <div class="card-plain">
            <div class="header">                            
                <h5>Forgot Password?</h5>
                <span>Enter your e-mail address below to reset your password.</span>
            </div>
            <form class="form">                            
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Email">
                    <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                </div>
            </form>
            <div class="footer">
                <a href="index.html" class="btn btn-primary btn-round btn-block">SUBMIT</a>                            
            </div>
            <!-- <a href="javascript:void(0);" class="link">Need Help?</a> -->
        </div>
    </div>
@endsection