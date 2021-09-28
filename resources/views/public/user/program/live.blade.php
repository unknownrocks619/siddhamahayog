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
                            <li class='breadcrumb-item'><a href="#">Recording(s)</a></li>
                            <li class='breadcrumb-item active' aria-current="page">Offline</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Offline Videos</h2>
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
                    <div class='card mt-4'>
                        <div class='card-header'>
                            <h4 class='card-title'>Live Session</h4>
                        </div>
                        <div class='card-body'>
                            @php
								//$subscribed_class = \DB::table('user_sadhak_registrations')
								//						->where("user_sadhak_registrations.user_detail_id",auth()->user()->user_detail_id)
								//						->join('event_video_classes',function ($join){
								//							return $join->on('user_sadhak_registrations.sibir_record_id','=','event_video_classes.event_id')
								//								->where('event_video_classes.is_active',true);
								//						})
								//						->join('sibir_records','sibir_records.id','=','user_sadhak_registrations.sibir_record_id')
								//						->select(["sibir_records.*","user_sadhak_registrations.sibir_record_id","user_sadhak_registrations.id as registration_id","user_sadhak_registrations.user_detail_id","event_video_classes.id as event_video_id"])
								//						->latest()
								//						->limit(1)
								//						->get();
								$subscribed_class = \App\Models\ZoomSetting::where('is_active',true)->orderByDesc("is_global")->get();
								//if ( ! $subscribed_class->count() ) {
									// zonal session.
								//	$get_zonal_configurations = \App\Models\ZoomSetting::select(['sibir_record_id','country_id','meeting_id','id','is_active'])
								//								->where('is_active',true)
								//								->get();
								//}
							@endphp
                            @if (! $subscribed_class->count() )
								<div class='card-body' style="background: ">
									<i class='d-flex fas fa-podcast img-fluid text-secondary justify-content-center' style='font-size:80px;'></i>
								</div>
                                <div class='card-footer'>
									<p class="text-info">You do not have any active live session.</p>
									<p class='text-danger'>Missed your Session !!	<span class='text-primary border-bottom'><a href="{{ route('public.offline.public_get_offline_videos') }}">Check Recorded Video</a></span></p>
							    </div>
							@endif

							@if( $subscribed_class->count() )
								<div class="card-body">
									<table class='table table-hover table-bordered'>
										<thead>
											<tr>
												<th>#</th>
												<th>Program Name</th>
												<th>Time</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										@foreach ($subscribed_class as $get_zonal_configuration)
												<tr>
													<td>
														{{ $loop->index+1 }}
													</td>
													<td>
														{{ $get_zonal_configuration->sibir->sibir_title }}
														@if($get_zonal_configuration->is_global)
															<span class='text-info'>(Global Session) </span>
														@else
															<span class='text-info'>({{ address($get_zonal_configuration->country_id,"country") }} Session) </span>
														@endif
													</td>
												
													<td>
														<a href="{{ route('modals.public_modal_display',['modal'=>'start-zoom-session-zonal','reference'=>'live_session_zonal','reference_id'=>encrypt($get_zonal_configuration->id)]) }}" data-toggle="modal" data-target="#page-modal" class='text-white border-bottom join_session btn btn-success'>Join Session</a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section("modal")
	<div class="modal fade custom-modal" id="page-modal">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content" id="modal_content">
				<div class="modal-body">
					<p>Please wait loading your video....</p>
				</div>
			</div>
		</div>
	</div>
@endsection

@section("page_js")
    <script type="text/javascript">
        $(document).ajaxStart(function() {
            $("#overlay").fadeIn(function() {
                $("#loading_text").html("Please wait... verifying request.. ");
            });
        });

        $(document).ajaxStop( function() {
            $("#overlay").fadeOut(function() {
                $("#loading_text").html('Please wait... Almost done....');
            });
        });
    </script>
	<script type="text/javascript">
		$('#page-modal').on('shown.bs.modal', function (event) {
			$('body').removeAttr('class');
			$.ajax({
				method : "GET",
				url : event.relatedTarget.href,
				success: function (response){
					$("#modal_content").html(response);
				}
			});
		})
	</script>
@endsection