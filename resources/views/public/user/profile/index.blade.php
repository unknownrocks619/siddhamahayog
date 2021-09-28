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
					<h4 class="mb-4"> Account Setting </h4>
					<div class='row'>
						<div class='col-md-12 mb-3'>
							<form method="post" enctype='multipart/form-data' action="{{ route('public.public_change_profile') }}">
							@csrf
								<div class='card'>
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
									@if($user_detail->profile_id)
										<img src="{{ profile_asset($user_detail->profile_id) }}" class="card-img-top" style="height:140px; width:140px;margin:auto" />
									@else
										<img src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg" class="card-img-top" style="height:140px;width:140px;margin:auto" />
									@endif
									<div class='card-header'>
										<h4 class='card-title'>Profile Settings</h4>
									</div>
									<div class='card-body'>
										<div class='form-row'>
											<label class='label-control'>Upload Imge</label>
											<input type="file" name='upload' class='form-control' accept="image/*" />
										</div>
									</div>
									<div class='card-footer'>
										<div class='row'>
											<div class="col-md-12">
												<button type="submit" class='btn btn-success'>Upload Profile Picture</button>
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