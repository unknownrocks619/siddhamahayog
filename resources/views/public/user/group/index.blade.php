@extends("layouts.clients")


@section("page_css")
    <style type="text/css">
        #overlay {
        background: #ffffff;
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 10%;
        opacity: .80;
        }
        
        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection


@section("breadcrumb")
    <!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item"> <a href="{{ route('public_user_dashboard') }}">Dashboard</a></li>
                            <li class='breadcrumb-item'><a href="#">Settings</a></li>
                            <li class='breadcrumb-item active' aria-current="page"><a href="#">Family Setup</a></li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Family Member</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
	<div id="overlay" style="display:none;">
        <div class="spinner"></div>
        <br/>
		<h4 id="loading_text">Please wait... Connecting to server...</h4>
    </div>
    <div class="container-fluid" style="padding-left:0px;">
        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px;padding-right:0px">
                @include("public.inc.navigation")
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
				<div class='card'>
					<div class='card-header'>
						<a class='btn btn-primary btn-sm' href="{{ route('public.family.public_add_family_to_event') }}"><i class='fas fa-users'></i> &nbsp;Add Family Member</a>
					</div>
					<div class='card-body'>
						<form id="member_search_form" method="get" action="{{ route('public.family.public_list_family_member') }}">
							@csrf
							<div class='row'>
								<div class='col-md-3'>
									<label class='label-control'>Select Event</label>
									<select class='form-control' name='event'>
										<option value="">Click to Change</option>
										@php
											$users_involved_event = \App\Models\UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)->get();
											foreach ($users_involved_event as $user_event) {
												echo "<option value='".encrypt($user_event->sibir_record->id)."'>";
														echo $user_event->sibir_record->sibir_title;
												echo "</option>";
											}

										@endphp
									</select>
								</div>
								<div class='col-md-3'>
									<label class='label-control'>Select Year</label>
									<select class='form-control' name='year'>
										<option value="2021">2021 / 2078</option>
									</select>
								</div>
								<div class='col-md-3'>
									<label class="label-control">Record Type</label>
									<select class='form-control' name='record_type'>
										<option value="my-group">My Group</option>
										<option value="other-group">Other Group</option>
									</select>
								</div>
								<div class='col-md-3 pt-3 mt-2'>
									<button type="button" id="filter_member_list" class='btn  btn-block btn-info'>List My Family Member</button>
								</div>
							</div>
						</form>
					</div>
					<div class='card-body' id='member-list'></div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section("modal")
<div class="modal fade custom-modal" id="page-modal">
		<div class="modal-dialog">
			<div class="modal-content" id="modal_content">
				<div class="modal-body">
					<p>Please wait loading your content....</p>
				</div>
			</div>
		</div>
	</div>
@endsection
@section("page_js")
	<script type="text/javascript">
        $(document).ajaxStart(function() {
            $("#overlay").fadeIn(function() {
                $("#loading_text").html("Please wait... Submitting your family detail.. ");
            });
        });

        $(document).ajaxStop( function() {
            $("#overlay").fadeOut(function() {
                $("#loading_text").html('Please wait... Connecting to server...');
            });
        });
    </script>
	<script>
		$("#filter_member_list").click( function () {
			// get current form values
			$.ajax({
				type : "POST",
				data : $('form#member_search_form').serializeArray(),
                url : $('form#member_search_form').attr("action"),
				success : function ( response ) {
					$("#member-list").html(response);
				}
			});
		})
	</script>
@endsection