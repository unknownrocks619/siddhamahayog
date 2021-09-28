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
					<h2 class="breadcrumb-title">Dashboard - Black Theme</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3">
				@include("public.inc.navigation")
				@php
				    $load_offline = false;
				//    $active_class = \App\Models\EventVideoClass::get();
				 $active_class = \App\Models\EventVideoClass::where('is_active',true)->get();
				 if(! $active_class->count() ){
				    $load_offline = true;
				    $available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->latest()->get();
				 }
                    //dd($active_class->count());
                    // $available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->latest()->get();


				@endphp
			</div>
			
			<div class="col-md-7 col-lg-8 col-xl-9">
				<p class='text-danger'>
						<!--If case of  any problem in the system. Please Contact Our IT Support with following Detail: <br /> Ticket No:-->
						@php
//							$user_detail = \App\Models\userDetail::find(auth()->user()->user_detail_id);
//							echo $user_detail->id . "-".time();
						@endphp
					</p>
				<div class="row">
					<div class="col-md-12">
					    @if($load_offline)
					        <h4 class='mb-4'>Offline Session</h4>
				        @else
    						<h4 class="mb-4">Ongoing Session</h4>
				        @endif
						<div class="appointment-tab">

						
							
							<div class="tab-content">
							
								<!-- Upcoming Appointment Tab -->
								<div class="tab-pane show active" id="upcoming-appointments">
									<div class="card  mb-0">
										<div class="card-body card-table">
										<x-alert></x-alert>
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>Event Name</th>
															<th>Event Type</th>
															<th>Event Starts At</th>
															<th>Type</th>
														</tr>
													</thead>
													<tbody>
														
														@foreach ($active_class as $live_session)
														<tr>
															<td>
																<h2 class="table-avatar">
																	<a href="#">{{ $live_session->event_source->sibir_title }}</a>
																</h2>
															</td>
															<td>
																@if($live_session->is_active)
																	<span class='btn btn-sm bg-success text-white'>LIVE</span></td>
																@else
																	<span class="btn btn-sm bg-danger text-white">OFF</span>
																@endif
															<td>
																@php
																	$class_log = \App\Models\VideoClassLog::where('event_video_class_id',$live_session->id)
																											->where('active',true)
																											->first();
																	if( ! $live_session->is_active && ! $load_offline){
																	    $load_offline = true;
																	    $available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->latest()->get();
																	}
																@endphp
																@if($live_session->is_active && $class_log)
																    {{ date("Y-m-d h:i A",strtotime($class_log->start_time)) }}
																@else
																    {{ date('h:i A',strtotime($live_session->class_start)) }}
																@endif
																<br />Time zone: {{ config('app.timezone')}}</td>
															<td>ZOOM</td>
														</tr>
														<tr>
															<td>
																@if( $live_session->is_active )
																	<form method="post" target="_blank" action="{{ route('public_class_start') }}">
																		@csrf
																		<input type="hidden" name='class' value="{{ encrypt($live_session->id) }}" />
																		<button type="submit" class='btn btn-success'>
																			Join Session 
																		</button>
																		@if(! $live_session->meeting_lock)
																			<span class='text-warning'>This session is locked. New Entries are blocked.</span>
																		@endif
																	</form>
																@else
																	<button type="button" class='btn btn-secondary'>Join Session</button>
																	<br />
																	<span class='text-info'>
																	    Please remember to refresh this page to check if the zoom is active at the given time.
																	    or <a href='#' onclick='window.location.reload()'>Click Here</a> 
																	</span>
																@endif
															</td>
														</tr>
														@endforeach
														
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
											</div>
										</div>
									</div>
								</div>
								<!-- /Upcoming Appointment Tab -->
							
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
@endsection

@section("page_js")
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