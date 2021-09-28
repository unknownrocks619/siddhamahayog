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
                    <div class='card mt-4'>
                        <div class='card-header'>
                            <h4 class='card-title'>Offline Recording(s)</h4>
                        </div>
                        <div class='card-body'>
                            @php
                                $offline_videos = \App\Models\OfflineVideo::with('event_source')->where('is_private',true)->latest()->paginate(7);
                            @endphp
                            <table class='table table-bordered table-hover'>

                                @foreach ($offline_videos as $videos)
                                    <tr>
                                        <td>
                                            {{ $videos->event_source->sibir_title }} - {{ $videos->video_title }}
                                        </td>
                                        <td>
                                            <a  data-target="#page-modal" data-toggle="modal" href="{{ route('modals.public_modal_display',['modal'=>'youtube_modal','reference'=>'Offline','reference_id'=>encrypt($videos->id)]) }}" class="btn btn-sm btn-info">
                                                <i class='fas fa-eye-open'></i>
                                                Watch
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $offline_videos->links() }}
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