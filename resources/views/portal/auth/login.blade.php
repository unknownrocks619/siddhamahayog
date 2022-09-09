@extends("layouts.portal.guest")

@section("page_title")
- Authetication Required
@endsection

@section("page_css")
<style type='text/css'>
    .btn-facebook {
        color: #fff;
        background-color: #3b5998;
        border-color: rgba(0, 0, 0, 0.2);
    }

    .btn-social {
        position: relative;
        padding-left: 44px;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-social:hover {
        color: #eee;
    }

    .btn-social :first-child {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 40px;
        padding: 7px;
        font-size: 1.6em;
        text-align: center;
        border-right: 1px solid rgba(0, 0, 0, 0.2);
    }

    .login-with-google-btn {
        transition: background-color .3s, box-shadow .3s;

        padding: 12px 16px 12px 42px;
        border: none;
        border-radius: 3px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);

        color: #757575;
        font-size: 14px;
        font-weight: 500;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;

        background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
        background-color: white;
        background-repeat: no-repeat;
        background-position: 12px 11px;

        &:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
        }

        &:active {
            background-color: #eeeeee;
        }

        &:focus {
            outline: none;
            box-shadow:
                0 -1px 0 rgba(0, 0, 0, .04),
                0 2px 4px rgba(0, 0, 0, .25),
                0 0 0 3px #c8dafc;
        }

        &:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
            cursor: not-allowed;
        }
    }
</style>
@endsection

@section("content")
<div class="col-lg-5 col-md-12 offset-lg-1">
    <div class="card-plain">
        <div class="header">
            <h5>Welcome, Log in</h5>
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div id="error"></div>
        <form id="login-form" class="form" method="post" action="{{ route('login') }}">
            @csrf
            <input type="hidden" id="user_recap" name="g_cap_res" />
            <div class="input-group">
                <input type="text" class="form-control" name="email" placeholder="User Email">
                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" class="form-control" />
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
            </div>
            <hr />

            <div class="footer">
                <button type="submit" class="btn btn-primary btn-round btn-block">SIGN IN</button>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('social_login_redirect') }}" class="btn btn-lg btn-social btn-facebook text-white">
                            <i class="zmdi zmdi-facebook text-white pt-3"></i> Sign in with Facebook
                        </a>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button" class="login-with-google-btn">
                            Sign in with Google
                        </button>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn btn-primary btn-simple btn-round btn-block">SIGN UP</a>
            </div>
        </form>
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="link">Forgot Password?</a>
        @endif
    </div>
</div>
@endsection

@section("footer_script")
<script src="https://www.google.com/recaptcha/api.js?render=6LcmdQseAAAAANehy0ummHfv31NMLNjAAd3LKmJx"></script>
<script>
    $(document).ready(function() {
        invokeCaptcha();
    });

    function invokeCaptcha() {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcmdQseAAAAANehy0ummHfv31NMLNjAAd3LKmJx', {
                action: 'contact'
            }).then(function(token) {
                // Add your logic to submit to your backend server here.
                document.getElementById("user_recap").value = token
            });
        });

    }

    function confirmSubmit() {
        if (document.getElementById("user_recap").value == "") {
            $("#error").addClass("alert alert-danger");
            $("#error").fadeIn("fast", function() {
                $(this).html("Invalid Captcha. Please Try Again.");
                invokeCaptcha();
            });
            return false;
        }
        return true;
    }
</script>
@endsection