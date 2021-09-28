@extends("layouts.clients")

@section("breadcrumb")
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Absent Requestion Log</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
	<div class="container-fluid" style="padding-left:0px;">
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px">
				@include("public.inc.navigation")
			</div>
			
			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class="row">
					<div class="col-md-12">
						<h4 class="mb-4">Your Absent Record</h4>
						<p class='text-info'>Only leave application report is shown here. To check your attendance please refer to setting > attendance section</p>
						<div class="card">
							<div class='card-header'>
                                <a href="{{ route('public.event.public_request_absent_form') }}" class='btn btn-primary btn-sm'>Add Leave Request</a>
							</div>
							<div class="card-body">
								<form id="filter_absent_form" action="{{ route('public.event.public_display_absent_record') }}" method="post">
									@csrf
									<div class='row'>
										<div class='col-md-8'>
											<select name="event" class='form-control'>
												<option value="">Select Event</option>
												@foreach ($user_sibirs as $sibir)
													<option value='{{ encrypt($sibir->sibir_record->id) }}'>{{ $sibir->sibir_record->sibir_title }}</option> 
												@endforeach
											</select>
										</div>
										<div class='col-md-4'>
											<button type="submit" class='btn btn-secondary'>Filter Record</button>
										</div>
									</div>
								</form>
								<x-alert></x-alert>
								<div class="table-responsive" id="user_data">
									
								</div>
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
		$("form#filter_absent_form").submit(function(event) {
			event.preventDefault();
			if ( $("select[name='event']").val() == "") {
				alert("Please select your event.")
			} else{
				$.ajax({
					type : $(this).attr("method"),
					url : $(this).attr("action"),
					data : $(this).serializeArray(),
					success : function ( response ) {
						$("#user_data").html(response);
					}
				})
			}
			
		})
	</script>
@endsection