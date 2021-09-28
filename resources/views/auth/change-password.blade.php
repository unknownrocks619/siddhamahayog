<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Sadhak Entry Portal</title>
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset ('gp/portal/assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset ('gp/portal/assets/css/font-awesome.min.css') }}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('gp/portal/assets/css/style.css') }}">
		
		<!--[if lt IE 9]>
			<script src="{{ asset ('gp/portal/assets/js/html5shiv.min.js') }}"></script>
			<script src="{{ asset ('gp/portal/assets/js/respond.min.js') }}"></script>
		<![endif]-->
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="{{ asset ('psm-logo.png') }}" alt="Siddha Mahayoga">
                        </div>
                        <div class="login-right">
                            @if($validate)
							<div class="login-right-wrap">
								<h1>Recover Your Account</h1>
                                <p></p>
                                <x-alert></x-alert>
								<!-- Form -->
								<form method="post" action="{{ route('public_save_change_password') }}">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $validate->key }}" />
									<div class="form-group">
                                        <label class='control-label'>New Password</label>
										<input class="form-control" name="password" required type="password" placeholder="New Password">
									</div>
                                    <div class="form-group">
                                        <label class='control-label'>Confirm Password</label>
										<input class="form-control" name="password_confirmation" required type="password" placeholder="Confirm New Password">
									</div>
									<div class="form-group">
										<button class="btn btn-primary btn-block" type="submit">Confirm Change Password</button>
									</div>
								</form>
							</div>
                            @else
                                <div class='login-right-wrap'>
                                    <p class='text-danger'>
                                        Your Link has expired or your provided link in invalid.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{ asset ('gp/portal/assets/js/jquery-3.2.1.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset ('gp/portal/assets/js/popper.min.js') }}"></script>
        <script src="{{ asset ('gp/portal/assets/js/bootstrap.min.js') }}"></script>
    </body>
</html>

