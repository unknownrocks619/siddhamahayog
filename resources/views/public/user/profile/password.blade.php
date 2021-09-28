@extends("layouts.clients")

@section("breadcrumb")
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Profile</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Profile Management</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
			@include("public.inc.navigation")
		</div>
		<div class="col-md-7 col-lg-8 col-xl-9">
			<div class="row">
				<div class='col-md-6'>
                <x-alert></x-alert>

					<div class='row'>
						<div class='col-md-12'>
							<div class="appointment-tab">
								<form method="post" action="{{ route('public.public_change_password') }}">
									@csrf
									<div class="card mb-0">
										<div class='card-header'>
											<h4>Password Settings</h4>
										</div>
										<div class='card-body'>
											@if(session()->has('p_success'))
												<div class='row mb-2'>
													<div class='col-md-12 alert alert-success'>
														{{ session()->get("p_success") }}
													</div>
												</div>
											@endif
											@if(session()->has('p_error'))
												<div class='row mb-2'>
													<div class='col-md-12 alert alert-error'>
														{{ session()->get("p_error") }}
													</div>
												</div>
											@endif
											<div class='form-row'>
												<label class='control-label'>Current Password</label>
												<input type="password" class="form-control" name="old_password" />
												@error("old_password")
													<div class='text-danger'> {{ $message }} </div>
												@enderror
											</div>
											<div class='form-row mt-2'>
												<label class='control-label'>New Password</label>
												<input type="password" name="password" class='form-control' />
												@error("password")
													<div class='text-danger'> {{ $message }} </div>
												@enderror
											</div>
											<div class='form-row mt-2'>
												<label class='control-label'>Confirm New Password</label>
												<input type="password" name="password_confirmation" class='form-control' />
											</div>
										</div>
										<div class='card-footer'>
											<div class='row'>
												<div class='col-md-12'>
													<button type="submit" class='btn btn-danger'>Change Password</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection