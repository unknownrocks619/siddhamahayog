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
							<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Dashboard</h2>
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

	<div class="container-fluid" >
		
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3">
				@include("public.inc.navigation")
				@php
				    $load_offline = false;
				//    $active_class = \App\Models\EventVideoClass::get();
					$active_class = \App\Models\EventVideoClass::where('is_active',true)->get();
					if(! $active_class->count() ){
						$load_offline = true;
						$available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->with(['event_source'])->latest()->get();
					}
						//dd($active_class->count());
						// $available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->latest()->paginate(5);


				@endphp
			</div>
			
			<div class="col-md-7 col-lg-8 col-xl-9 pl-4">
				@include("public.inc.support-text")
				<div class="row">
					<div class="col-md-12">
						@if($load_offline)
					        <h4 class='mb-4'>Offline Session</h4>
				        @else
    						<h4 class="mb-4">Ongoing Session</h4>
				        @endif
						<div class="card">
							<div class='card-header'>
							</div>
							<div class="card-body">
								<x-alert></x-alert>
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0">
										<thead>
											<tr style="border-top:0px">
												<th style="border-top:0px">Event Name</th>
												<th style="border-top:0px">Event Status</th>
												<th style="border-top:0px">Event Starts At</th>
											</tr>
										</thead>
										<tbody>
											@if ( $active_class->count() )
												@foreach ($active_class as $live_session)
													@php
														$member = \App\Models\UserFamilyGroup::where('sibir_record_id',$live_session->event_source->id)
																							->where('member_id',auth()->user()->user_detail_id)
																							->where(function($query) {
																								return $query->where("status",true)
																											->where('approved',true);
																							})
																							->first();

													@endphp
													@if($member)
														<tr>
															<td colspan='3'>
																<p class='text-info'>You are grouped by {{ $member->leader_detail->full_name() }}. Please use his / her account to join the session.</p>
																<p class='text-muted'>Incase you are viewing seperately, Please deactivate your group from family / group setting.</p>
															</td>
														</tr>
													@else
														<tr rowspan='2' style='border-bottom:0px'>
															<td style="border:0px">
																<h2 class="table-avatar">
																	<a href="#">{{ $live_session->event_source->sibir_title }}</a>
																</h2>
																<br />
																<a href="{{ route('public.family.public_add_family_to_event',[encrypt($live_session->event_source->id)]) }}" class='btn btn-link'> <i class='fas fa-users'></i> Add Family Group</a>
															</td>

															<td style="border: 0px" >
																@if($live_session->is_active)
																	<span class='btn btn-sm bg-success text-white'>LIVE</span>
																@else
																	<span class="btn btn-sm bg-danger text-white">OFF</span>
																@endif
															</td>
															
															<td style="border:0px" >
																{{-- date("Y-m-dh:iA",strtotime($class_log->start_time)) --}}
																{{ date("h:i A",strtotime($live_session->class_start)) }}
																<br />Time zone: {{ config('app.timezone')}}
															</td>
														</tr>
														<tr>
															<td colspan='3' style="border:0px">
																@if($live_session->is_active)
																<form method="get" id="join_session" target="_blank" action="{{ route('modals.public_modal_display',['modal'=>'start-zoom-session','reference'=>'live_session','reference_id'=>encrypt($live_session->id)]) }}  {{-- route('public_class_start') --}}">
																	@csrf
																	<input type="hidden" name='class' value="{{ encrypt($live_session->id) }}" />
																	<button type="submit" class='btn btn-success'>
																		Join Session 
																	</button>
																</form>
																@else
																	<button type="button" class='btn btn-secondary'>Join Session</button>
																	<br />
																	<span class='text-info'>
																	Please remember to refresh this page to check if the zoom is active at the given time.						</span>
																@endif
															</td>
														</tr>
													@endif
												@endforeach
											@endif
											
											@if($load_offline && isset($available_video_classes))
														    @foreach ($available_video_classes as $active )

        														<tr>
        															<td>
        																<h2 class="table-avatar">
        																	<a href="#">{{ $active->event_source->sibir_title }}</a> - {{ $active->video_title }}
        																</h2>
        																<br />
        																<a href="{{ route('modals.public_modal_display',['modal'=>'youtube_modal','reference'=>'Offline','reference_id'=>encrypt($active->id)]) }}" 
        																		data-toggle='modal' data-target="#page-modal" class="btn btn-sm bg-info-light">
        																		<i class="far fa-eye"></i> Watch Recording
        																	</a>
        															</td>
        															<td> <span class='btn btn-sm bg-warning'>{{$active->source}}</span></td>
        															<td>{{ date("Y-m-d h:i A",strtotime($active->created_at)) }}</td>
        															<td>--</td>
        															
        														</tr>
    														@endforeach
														@endif
										</tbody>
									</table>
									@if($load_offline && isset($available_video_classes))
										{{-- $available_video_classes->links() --}}
									@endif
								</div>
							</div>
						</div>
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
	<div class="modal fade custom-modal" id="session-modal">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content" id="session_modal_content">
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
					$("#session_modal_content").html(response);
				}
			});
		})
	</script>
	@if( $active_class )
	
	<script>

		$('#session-modal').on('shown.bs.modal', function (event) {
			$('body').removeAttr('class');
			$.ajax({
				method : "GET",
				url : $("form#join_session").attr("action"),
				success: function (response){
					$("#session_modal_content").html(response);
				}
			});
		})

		$("form#join_session").submit(function(event) {
			event.preventDefault();
			$.ajax({
				type : $(this).attr('method'),
				url : $(this).attr('action'),
				data : $(this).serializeArray(),
				success: function (response) {
					$("#session-modal").modal('show');
				}
			})
		})		
	</script>
	@endif
@endsection