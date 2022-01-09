@extends("layouts.clients")

@section("breadcrumb")
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('public_user_dashboard')}}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Exam / Evaulation</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Exam / Evaulation</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
	<script>
		const countTimeDown = function (elId,expire_date,disable_button='answer_button') {
			// Set the date we're counting down to
			var countDownDate = new Date(expire_date).getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();
				
			// Find the distance between now and the count down date
			var distance = countDownDate - now;
				
			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				
			// Output the result in an element with id="demo"
			document.getElementById(elId).innerHTML = days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s ";
				
			// If the count down is over, write some text 
			if (distance < 0) {
				$("."+disable_button).removeAttr('href').addClass('disabled')
				clearInterval(x);
				document.getElementById(elId).innerHTML = "EXPIRED";
			}
			}, 1000);
		}
	</script>
	<div class="container-fluid" style="padding-left:0px">
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px;padding-right:0px;background:#31353D !important">
				@include("public.inc.navigation")
				@php
				$active_class = \App\Models\EventVideoClass::get();
				// $active_class = \App\Models\EventVideoClass::where('is_active',true)->get();
                    //dd($active_class->count());
                    $available_video_classes = \App\Models\OfflineVideo::where('is_active',true)->latest()->get();


				@endphp
			</div>
			
			<div class="col-md-7 col-lg-8 col-xl-9">
				<p class='text-danger'>
						If case of  any problem in the system. Please Contact Our IT Support with following Detail: <br /> Ticket No:
						@php
							$user_detail = \App\Models\userDetail::find(auth()->user()->user_detail_id);
							echo $user_detail->id . "-".time();
						@endphp
					</p>
				<div class="row">
					<div class="col-md-12">
						<h4 class="mb-4">Exams Center / परीक्षा केन्द्र</h4>
                        <div class="appointments">
							@foreach ($collections as $collection)
                                @php
									// parse exam end date.
									$exam_close_date = \Carbon\Carbon::parse($collection->exam_end_date);
                                    $user_allowed = \App\Models\UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
																						->where('sibir_record_id',$collection->sibir_record_id)
                                                                                       ->first();
									$signed_url = URL::temporarySignedRoute(
														'public.exam.public_examination_start',
														now()->addMinute(($collection->total_exam_time) ? $collection->total_exam_time : 60) ,
														[encrypt($collection->id)]);


									// check if user have already attempted.
									$user_attempt = \App\Models\UserAnswer::where('question_collection_id',$collection->id)
																					->where('user_login_id',auth()->id())
																					->first();
									if($user_attempt && $user_attempt->total_attempt != $collection->questions->count() ) {
										// last question attemp.
										$last_question = \App\Models\UserAnswersSubmit::where('user_login_id',auth()->id())
															->where('question_collection_id',$collection->id)
															->latest()->first();
										// now lets fetch question.
										$question_singed_url = \App\Models\Questions::where('question_collections_id',$collection->id)
																	//->where('user_login_id',auth()->id())
																	->where('id' , '>',$last_question->question_id)
																	->first();
										if ($question_singed_url) {
											$signed_url = URL::temporarySignedRoute(
														'public.exam.public_examination_start',
														now()->addMinute(3600) ,
														[encrypt($collection->id),"q"=>$question_singed_url->id]);
										}
									}

                                @endphp
                                @if( $user_allowed)
                                    <!-- Appointment List -->
                                    <div class="appointment-list @if( $user_attempt && $user_attempt->total_attempt == $collection->questions->count()) bg-success-light  @elseif( $user_attempt &&  $user_attempt->total_attempt == $collection->questions->count()) bg-info-light @endif">
                                        <div class="profile-info-widget">
                                            <div class="profile-det-info">
                                                <!-- <h3>
													<a href="#check_eligibility"> -->
														{{-- $collection->sibir->sibir_title --}}
													<!-- </a>
												</h3> -->
                                                <h3><strong> <a href='#' class='text-info' style="color: #0f6674!important">{{ $collection->question_term  }}</a></strong> </h3>
													<p class='text-danger' id='demo_{{$collection->id}}'>Loading</p>
													@php
														$date = date("M d, Y",strtotime($collection->exam_end_date));
														$date_with_time = $date . " 22:13:00";
													@endphp
													<script>
														countTimeDown("demo_{{$collection->id}}","{{$date_with_time}}","answer_button_{{$collection->id}}")
													</script>
                                                <!-- <p> Start Date: {{-- $collection->exam_start_date --}} </p> -->
                                                <!-- <p>Total Duration: {{-- $collection->total_exam_time --}} Minute</p> -->
                                            </div>
                                        </div>
										@if( ! $exam_close_date->isToday() && $exam_close_date->isPast() )
										<div class="appointment-action">
											<a href="{{ route('modals.public_modal_display',['modal'=>'view-result','reference'=>'q_collection','reference_id'=>encrypt($collection->id)]) }}" data-toggle='modal' data-target="#page-modal" class="btn btn-lg bg-info text-white">
												<i class="far fa-file"></i> नतिजा 
											</a>
										</div>
										@else
											<div class="appointment-action">
												@if( ! $user_attempt)
													<a href="{{ $signed_url }}" class="btn btn-lg bg-info text-white answer_button_{{$collection->id}}">
														<i class="far fa-eye"></i> Answer the questions / प्रश्नका उत्तर दिनुहोस 
													</a>
													<a href="javascript:void(0);" class="btn btn-lg bg-success">
														<i class="fas fa-check"></i>  Result / नतिजा 
													</a>
												@elseif ($user_attempt && $user_attempt->answers->count() == $collection->questions->count())
													<a href="{{ route('modals.public_modal_display',['modal'=>'view-result','reference'=>'q_collection','reference_id'=>encrypt($collection->id)]) }}" data-toggle='modal' data-target="#page-modal" class="btn btn-lg bg-info text-white">
														<i class="far fa-file"></i> नतिजा 
													</a>
												@else ($user_attempt && $user_attempt->answers->count() != $collection->questions->count())
													<a href="{{ $signed_url }}" class="btn btn-lg bg-info text-white answer_button_{{$collection->id}}">
														<i class="far fa-eye"></i> Continue answer / जारी राख्नुहोस 
													</a>
												@endif
											</div>
										@endif
                                        
                                    </div>
                                    <!-- /Appointment List -->
								@else
                                    <!-- Appointment List -->
                                    <div class="appointment-list">
                                        <div class="profile-info-widget">
                                            <div class="profile-det-info">
                                                <h3><a href="#check_eligibility">You don't have any exams scheduled.</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Appointment List -->								
								@endif

                            @endforeach
                        </div>
                    </div>
				</div>
			</div>
		</div>

	</div>

@endsection

@section("modal")
<div class="modal fade custom-modal" id="page-modal">
		<div class="modal-dialog modal-dialog-scrollable modal-xl">
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