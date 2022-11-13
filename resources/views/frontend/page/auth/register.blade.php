<html>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style>
    body {
        padding-top: 4.2rem;
        padding-bottom: 4.2rem;
        background: rgba(0, 0, 0, 0.76);
    }

    a {
        text-decoration: none !important;
    }

    h1,
    h2,
    h3 {
        font-family: 'Kaushan Script', cursive;
    }

    .myform {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        padding: 1rem;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 1.1rem;
        outline: 0;
        max-width: 500px;
        /* height: 100%; */
    }

    .tx-tfm {
        text-transform: uppercase;
    }

    .mybtn {
        border-radius: 50px;
    }

    .login-or {
        position: relative;
        color: #aaa;
        margin-top: 10px;
        margin-bottom: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .span-or {
        display: block;
        position: absolute;
        left: 50%;
        top: -2px;
        margin-left: -25px;
        background-color: #fff;
        width: 50px;
        text-align: center;
    }

    .hr-or {
        height: 1px;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }

    .google {
        color: #666;
        width: 100%;
        height: 40px;
        text-align: center;
        outline: none;
        border: 1px solid lightgrey;
    }

    .facebook {
        color: #065ad7;
        width: 100%;
        height: 40px;
        text-align: center;
        outline: none;
        border: 1px solid skyblue;
    }

    .facebook:hover {
        background: rgba(0, 0, 0, .2);
    }

    form .error {
        color: #ff0000;
    }

    #second {
        display: none;
    }

    .background {
        height: 100vh;
        width: 100vw;
        background: url("https://img.freepik.com/free-vector/gradient-galaxy-background_23-2148965436.jpg?w=740&t=st=1660197732~exp=1660198332~hmac=fae0b9479541dd44f8a3ad9b9d541aeb7bff37f97f5fa89c10260b1cb7980d3b");
        background-position: center;
        background-size: cover;
        opacity: 0.5;
        position: fixed;
        top: 0;
        bottom: 0;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-5 mx-auto">
                <x-alert></x-alert>
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1>Register</h1>
                            </div>
                        </div>
                        <form action="{{ route('register') }}" id="loginForm" method="post" name="login">
                            @csrf
                            @google_captcha()
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="">Full Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="full_name" required id="full_name" class="form-control @error('full_name') border border-danger @enderror" />

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eid">Email address
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input required aria-required="true" type="email" name="email" class="form-control @error('email') border border-danger @enderror" id="eid" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password
                                    <sup class="text-danger">*</sup>

                                </label>
                                <input required aria-required="true" type="password" name="password" id="pass" class="form-control @error('password') border border-danger @enderror" aria-describedby="password" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password
                                    <sup class="text-danger">*</sup>

                                </label>
                                <input required aria-required="true" type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') border border-danger @enderror" aria-describedby="password" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <label for="reference_by">
                                    Reference Code
                                </label>

                                <input type="text" name="sharing_code" id="sharing_code" class="form-control">
                            </div>

                            <div class="form-group">
                                <p class="text-center">By signing up you accept our <a href="https://siddhamahayog.org/terms-and-condition">Terms Of Use</a></p>
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Register</button>
                            </div>
                        </form>

                        <div class="col-md-12 ">
                            <div class="login-or">
                                <hr class="hr-or">
                                <span class="span-or">or</span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <form action="{{ route('social_login_redirect_google') }}" id="facebookForm" method="post">
                                @csrf
                                <p class="text-center">
                                    <button type="submit" class="btn mybtn w-100 btn-outline-primary"><i class="fa fa-facebook">
                                        </i> Signup using Facebook
                                    </button>
                                </p>
                            </form>
                        </div>
                        <div class="col-md-12 mb-3">

                            <form action="{{ route('social_login_redirect',['facebook']) }} id=" googleForm" method="post">
                                @csrf
                                <p class="text-center">
                                    <button type='submit' class=" btn mybtn btn-outline-danger w-100"><i class="fa fa-google-plus">
                                        </i> Signup using Google
                                    </button>
                                </p>
                            </form>
                        </div>
                        <div class="form-group">
                            <p class="text-center">Already have an account? <a href="{{ route('login') }}" id="signup">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.google.site_key') }}"></script>

<script>
    $(document).ready(function() {
        $("#loginForm").validate({
            rules: {
                "full_name": {
                    required: true
                },
                "email": {
                    required: true,
                },
                "password": {
                    required: true
                },
            },
            messages: {
                "email": "Provide Valid Email.",
                "password": "Password Field is Required"
            },
            onsubmit: true,
            onfocusout: true,
            validClass: "alert alert-success"
        });
    })
</script>

<script>
    grecaptcha.ready(function() {
        document.getElementById('loginForm').addEventListener("submit", function(event) {
            event.preventDefault();
            const inputs = [...$(this).find("input")];
            let valid = inputs.every(input => input.reportValidity());
            if (valid) {
                $(this).find("button").prop('disabled', true);
                grecaptcha.execute("{{ config('captcha.google.site_key') }}", {
                        action: 'login'
                    })
                    .then(function(token) {
                        document.getElementById("recaptcha_token").value = token;
                        document.getElementById('loginForm').submit();
                    });
            }
        });
    });
</script>


</html>