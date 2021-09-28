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
				<div class="col-md-12">
                    <x-alert></x-alert>
					<div class="appointment-tab">
						<form method="post" action="{{ route('public.public_personal_profile_store') }}">
							@csrf
							<div class="card mb-0">
								<div class='card-header'>
									<h4>Personal Settings</h4>
								</div>
								<div class="card-body"> 
									<div class='form-row'>
										<div class='col-md-6'>
											<label class='control-label'>First Name</label>
											<input value="{{ old('first_name',$user_detail->first_name) }}" type="text" class='form-control' name='first_name' required />
											@error("first_name")
											<div class='text-danger'>{{ $message }}</div>
											@enderror
										</div>
										<div class='col-md-6'>
											<label class='control-label'>Last Name</label>
											<input value="{{ old('last_name',$user_detail->last_name) }}" type="text" class='form-control' name='last_name' required />
											@error("last_name")
												<div class='text-danger'></div>
											@enderror
										</div>
									</div>

									<div class='form-row mt-4'>
										<div class="col-md-12">
											<label class='control-label'>Phone Number</label>
											<input type="text" class='form-control' name="phone_number" readonly value="{{ old('phone_number',$user_detail->phone_number) }}" />
											@error("phone_number")
												<div class='text-danger'> {{ $message }} </div>
											@enderror
										</div>
									</div>
									<div class='form-row mt-4'>
										<div class="col-md-6">
											<label class='control-label'>Date of Birth</label>
											<input name='date_of_birth' type="date" class='form-control' value="{{ old('date_of_birth', date('Y-m-d',strtotime($user_detail->date_of_birth_eng))) }}" />
											@error("date_of_birth")
												<div class='text-danger'> {{ $message }} </div>
											@enderror
										</div>
										<div class="col-md-6">
											<label class='control-label'>Gender</label>
											<select class='form-control' name="gender">
												<option value="male" @if(($user_detail->gender && $user_detail->gender=="male") || old('gender') == "male") selected @endif >Male</option>
												<option value="female"  @if(($user_detail->gender && $user_detail->gender=="female") || old('gender') == "female") selected @endif>Female</option>
												<option value="other"  @if(($user_detail->gender && $user_detail->gender=="other") || old('gender') == "other") selected @endif>Other</option>
											</select>
										</div>
										@error("gender")
											<div class='text-danger'> {{ $message }} </div>
										@enderror
									</div>

									<div class='form-row mt-4'>
										<div class="col-md-6">
											<label class='control-label'>Select Country</label>
											@if(  old('country') )
												<select id="country" class='form-control' name='country'>
													@php
														$countries = \App\Models\Countries::get();
													@endphp
													@foreach ($countries as $country)
														<option value="{{ $country->id }}" @if($country->id == old('country')) selected @endif> {{ $country->name }} </option>
													@endforeach
												</select>
											@elseif($user_detail)
												<select id="country" class='form-control' name='country'>
													@php
														$countries = \App\Models\Countries::get();
													@endphp
													@foreach ($countries as $country)
														<option value="{{ $country->id }}" @if($user_detail->country == $country->id) selected  @elseif( ! $user_detail->country && $country->code == "NP") selected @endif> {{ $country->name }} </option>
													@endforeach
												</select>
											@endif
											@error("country")
												<div class='text-danger'> {{ $message }} </div>
											@enderror
										</div>
										<div class="col-md-6">
											<label class='control-label'>City / State</label>
											@if( old('country'))
											<select id="city" class='form-control' name="city">
												@php
													$cities = \App\Models\City::where('country_id',old('country'))->get();
													foreach ($cities as $city) {
														echo "<option value='{$city->id}'>{$city->name}</option>";
													}
												@endphp
											</select>
											@else
												<select id="city" class='form-control' name="city">
												@php
													$country_id = ($user_detail->country) ? $user_detail->country : 153 ;
													$cities = \App\Models\City::where('country_id',$country_id)->get();
													foreach ($cities as $city) {
														echo "<option value='{$city->id}'";
															if($user_detail->city == $city->id) 
															{
																echo " selected ";		
															}
															echo ">{$city->name}</option>";
													}
												@endphp
											</select>
											@endif
										</div>
										@error("city")
											<div class="text-danger"> {{ $message }} </div>
										@enderror
									</div>
									
									<div class='form-row mt-4'>
										<div class="col-md-12">
											<label class='control-label'>Address</label>
											<textarea name="address" class='form-control'>{{ old('address',$user_detail->address) }}</textarea>
											@error("address")
												<div class='text-danger'> {{ $message }} </div>
											@enderror
										</div>
									</div>

								</div>
								<div class='card-footer'>
									<div class='row'>
										<div class='col-md-12'>
											<button type="submit" class='btn btn-primary'>Apply Changes</button>
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
@endsection

@section("page_js")
	<script type="text/javascript">
		$("#country").change(function() {
			$.ajax({
				type : "GET",
				url : "{{ route('cities-list') }}",
				data: "country="+this.value,
				dataType: "json",
				success: function(response) {
					let ids;
					let text = "";
					$(response.results).each( function (i, val) {
						text += "<option value='"+ val.id +"'>"+ val.text + "</option>";
					});
					$("#city").html(text);
				}
			})
		});
	</script>
@endsection