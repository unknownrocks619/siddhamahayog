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
                                <h1>Reset Your Password</h1>
                            </div>
                            <!-- <div class="col-md-12 alert alert-danger">
                                You can use your Arthapanchawk or Atirudri account to access the portal.
                            </div> -->
                        </div>
                        <form action="{{ route('password.email') }}" id="loginForm" method="post" name="login">
                            @csrf
                            @google_captcha()
                            <div class="form-group">
                                <label for="eid">Email address</label>
                                <input required aria-required="true" type="email" name="email" class="form-control @error('email') border border-danger @enderror" id="eid" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Submit</button>
                            </div>
                        </form>

                        <div class="form-group">
                            <p class="text-center">Don't have account? <a href="{{ route('register') }}" id="signup">Sign up here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.google.site_key') }}"></script>
<script>
    grecaptcha.ready(function() {
        document.getElementById('loginForm').addEventListener("submit", function(event) {
            $(this).children("input").prop('disabled');
            event.preventDefault();
            grecaptcha.execute("{{ config('captcha.google.site_key') }}", {
                    action: 'login'
                })
                .then(function(token) {
                    document.getElementById("recaptcha_token").value = token;
                    document.getElementById('loginForm').submit();
                });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#loginForm").validate({
            rules: {
                "email": {
                    required: true,
                },
                "password": {
                    required: true
                }
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

</html>