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
	<div class="container-fluid" style="padding-left:0px">
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px;background:#31353d">
				@include("public.inc.navigation")
				
			</div>
			
			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class='row'>
					<div class='col-md-12'>
						@include("public.inc.support-text")
					</div>
					<div class='col-md-8 mt-4 pt-4'>
						<div class='card'>
							<div class='card-header bg-primary'>
								<h4 class='card-title'>Live Session <i class='fas fa-podcast text-secondary'></i></h4>
							</div>
							@php
								// $subscribed_class = \DB::table('user_sadhak_registrations')
								//						->where("user_sadhak_registrations.user_detail_id",\Cache::store('file')->get('u_d')->id)
								//						->join('event_video_classes',function ($join){
								//							return $join->on('user_sadhak_registrations.sibir_record_id','=','event_video_classes.event_id')
								//								->where('event_video_classes.is_active',true);
								//						})
								//						->join('sibir_records','sibir_records.id','=','user_sadhak_registrations.sibir_record_id')
								//						->select(["sibir_records.*","user_sadhak_registrations.sibir_record_id","user_sadhak_registrations.id as registration_id","user_sadhak_registrations.user_detail_id","event_video_classes.id as event_video_id"])
								//						->latest()
								//						->limit(1)
								//						->get();
								$subscribed_class = \App\Models\ZoomSetting::where('is_active',true)
																			->with(['sibir'])
																			->orderByDesc('is_global')
																			->get();
							@endphp
							@if (! $subscribed_class->count() )
								<div class='card-body' style="background: ">
									<i class='d-flex fas fa-podcast img-fluid text-secondary justify-content-center' style='font-size:80px;'></i>
								</div>
							@endif
							@if( $subscribed_class->count() )
								<div class="card-body">
									<table class='table table-hover table-bordered'>
										<thead>
											<tr>
												<th>#</th>
												<th>Program Name</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($subscribed_class as $live_session)
														{{-- dd($live_session) --}}
												<tr>
													<td> {{ $loop->index+1 }} </td>
													<td>
														{{ $live_session->sibir->sibir_title }} 
														@if($live_session->is_global)
															<small class="text-primary">(Global Session)</small>
														@else
															<small class='text-primary'>({{ address($live_session->country_id,"country") }} Session)</small>
														@endif
													</td>
													<td>
													</td>
													<td>
														<a href="{{ route('modals.public_modal_display',['modal'=>'start-zoom-session-zonal','reference'=>'live_session_zonal','reference_id'=>encrypt($live_session->id)]) }}" data-toggle="modal" data-target="#page-modal" class='text-white border-bottom join_session btn btn-success'>
														<!-- <a href="{{-- route('modals.public_modal_display',['modal'=>'start-zoom-session','reference'=>'live_session','reference_id'=>$live_session->event_video_id]) --}}" data-toggle="modal" data-target="#page-modal" class='text-white border-bottom join_session btn btn-success'> -->
															Join Session
														</a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@endif
							<div class='card-footer'>
								@if ( ! $subscribed_class->count() )
									<p class="text-info">You do not have any active live session.</p>
									<p class='text-danger'>Missed your Session !!	<span class='text-primary border-bottom'><a href="{{ route('public.offline.public_get_offline_videos') }}">Check Recorded Video</a></span></p>
								@endif
							</div>
						</div>
					</div>
					<div class='col-md-4 mt-4 pt-4'>
						<div class='card'>
							<div class='card-header'>
								<h4 class='card-title'>Quick Navigation</h4>
							</div>
							<div class='card-body'>
								<ul>
									<li>
										<span class='text-secondary' style="color:#bdbdbd !important">Register for Program</span>
									</li>
									<li>
										<a href="{{ route('public.family.public_add_family_to_event') }}">Create Family / Group </a>
									</li>
									<li>
										<a href="{{ route('public.event.public_request_absent_form') }}">Leave Request</a>
									</li>
									<li>
										<span style="color:#bdbdbd !important" class='text-secondary'>Bookings</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class='row'>
					@include("public.user.dash.offline")
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

	<div class="modal custom-modal" id="notification">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<x-alert></x-alert>
				<div class="modal-header">
					<h4>Please Fill Following detail to proceed <sup class='text-danger'>*</sup></h4>
				</div>
				<form method="post" action="{{ route('public.user_personal_prof_update') }}">
					@csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<label for="education_label"  class="label-control">Education Level</label>
								<select class='form-control' name="education_level">
									<option value="none">None</option>
									<option value="primary">Primary</option>
									<option value="secondary">Secondary</option>
									<option value="higher_secondary">Higher Secondary</option>
									<option value="bachelors">Bachelors</option>
									<option value="masters">Masters</option>
									<option value="phd">PHd</option>
								</select>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-12">
								<label for="profession" class="label-control">
									Select Your Profession
								</label>
								<select type="text" class='form-control' name="profession">
									<option value="business">Business</option>
									<option value="engineer">Engineer</option>
									<option value="teacher">Teacher</option>
									<option value="professor">Professor</option>
									<option value="technician">Technician</option>
									<option value="computer_engineer">Computer Engineer</option>
									<option value="accountant">Accountant</option>
									<option value="nurse">Nurse</option>
									<option value="doctor">Doctor</option>
									<option value="student">Student</option>
									<option value="journalist">Journalist</option>
									<option value="photographer">Photographer</option>
									<option value="agriculture">Agriculture</option>
									<option value="literature">Literature</option>
									<option value="others">Others</option>
									<option value="house_wife">House Wife</option>
								</select>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-12">
								<label for="skills">Skills</label>
								<textarea class='form-control' name='skills'></textarea>
							</div>
						</div>
					</div>
					<div class='modal-footer'>
						<button type="submit" class='btn btn-danger'>Submit</button>
					</div>
				</form>
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
		$(window).on('load',function() {
			// $("#notification").fadewIn();
				// $("#notification").modal('show');
			
		})
		
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




		/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 *
 * jQuery.browser.mobile will be true if the browser is a mobile device
 *
 **/
// (function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
	</script>
@endsection