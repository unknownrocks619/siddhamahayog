@extends("layouts.clients")

@section("page_css")

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
    @php
    $final_video_id = null;
        if( ! $video_id ) {
            $last_video_watch = \App\Models\OfflineVideoAttendance::where('user_id',auth()->user()->user_detail_id)->latest()->first();
            if ($last_video_watch) {
                $offline_video = \App\Models\OfflineVideo::where('is_private',true)->find($last_video_watch->video_id);
                $final_video_id = $offline_video->id;
            }
        } else {
            $final_video_id = decrypt($video_id);
        }

    @endphp
<div id="overlay" style="display:none;">
        <div class="spinner"></div>
        <br/>
		<h4 id="loading_text">Please wait... Connecting to server...</h4>
    </div>
    <div class="container-fluid" style="padding-left:0px;">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xl-3" style="padding-left:0px;padding-right:0px;background:#31353D">
                <div class="page-wrapper chiller-theme toggled">
                  
                    <nav id="sidebar" class="sidebar-wrapper">
                        <div class="sidebar-content">
                            <div class="sidebar-menu">
                                <ul>
                                    @foreach($chapters as $chapter)
                                        <li class='sidebar-dropdown active'>
                                            <a href='#'> {{$chapter->chapter_name}} - <small class="text-white"> {{ $chapter->total_lessions }} videos </small> </a>
                                            <div class="sidebar-submenu"  style="display:block">
                                                <ul>
                                                    @foreach ($chapter->videos->sortBy('sortable') as $video)
                                                        <li>
                                                            <a @if($video->id == $final_video_id)  class='text-info' @endif href="{{ route('public.offline.public_get_video_detail',[$video->event_id,encrypt($video->id)]) }}">
                                                                {{$video->video_title}}
                                                                &nbsp;&nbsp;
                                                                <small class='text-danger text-right'>{{ $video->total_video_time }}</small>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        <!-- sidebar-menu  -->
                        </div>
                    </nav>
                </div>

            </div>
            <div class="col-md-9 col-lg-9 col-xl-9">
                <a href="{{ route('public_user_dashboard') }}" class='btn btn-danger btn-sm'>
                    <i class='fas fa-arrow-left'></i>    
                Go Back</a>
                    <!-- <div class='card'>
                        <div class="card-header">
                            <h4 class='card-title'>Filter Offline Videos</h4>
                        </div>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class="label-control">Video</label>
                                    <select class='form-control' name="video_type">
                                        @php
                                           // $sibirs = \App\Models\SibirRecord::where('video_type')
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    @if($video_id)
                    
                    @php
                        $offline_video = \App\Models\OfflineVideo::where('is_private',true)->find(decrypt($video_id));
                    @endphp
                    <div class='card mt-4'>
                        <div class='card-header'>
                            <h4 class='card-title'>{{$offline_video->video_title}}</h4>
                        </div>
                        <div class='card-body'>
                            <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $offline_video->youtube_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                            <p><a href="#">{{ $offline_video->video_title }}| </a> on <a href="#">Siddhamahayog.org</a>.</p>
                        </div>
                    </div>
                    @else
                        @php
                            $last_video_watch = \App\Models\OfflineVideoAttendance::where('user_id',auth()->user()->user_detail_id)->latest()->first();

                            if ($last_video_watch) {
                                $offline_video = \App\Models\OfflineVideo::where('is_private',true)->find($last_video_watch->video_id);
                            }
                        @endphp
                        <div class='card mt-3'>
                            <div class='card-body'>
                                @if($last_video_watch)
                                    <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $offline_video->youtube_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                                    <p>
                                        <a href="#">{{ $offline_video->video_title }} | </a> on <a href="#">Siddhamahayog.org</a>.</p>
                                @else
                                    <h5>Please Select Chapter from left navigation</h5>
                                @endif
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </div>
@php
    // lets check if this user have already watched.
    $user_detail = auth()->user()->user_detail_id;
    $attendance = \App\Models\OfflineVideoAttendance::where('video_id',$final_video_id)
                                                        ->where('user_id',$user_detail)
                                                        ->first();
    // check if this user is authorized.

    if ($attendance) {
        $attendance->total_watch = $attendance->total_watch + 1;
        $attendance->start_time = \Carbon\Carbon::now();
        $attendance->last_visit_time = \Carbon\Carbon::now();
        $attendance->save();

        // 
    } elseif(! $attendance) {
        $attendance = new \App\Models\OfflineVideoAttendance;
        $attendance->video_id = $final_video_id;
        $attendance->user_id = $user_detail;
        $attendance->total_watch = 1;
        $attendance->last_visit_time = \Carbon\Carbon::now();
        $attendance->start_time = \Carbon\Carbon::now();
        $attendance->save();
    }
@endphp
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