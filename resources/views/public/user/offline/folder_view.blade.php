@extends("layouts.clients")

@section("page_css")
 <style type="text/css">

h1,h2,h3{font-weight:300}

.folder,.item{margin-right:10px;position:relative}
#searchbar{display:block;width:100%;padding:20px 40px;font-size:18px}
#searchbar::-webkit-input-placeholder{color:#b9b9b9}
#searchbar::-moz-placeholder{color:#b9b9b9}
#searchbar:-ms-input-placeholder{color:#b9b9b9}
#searchbar:-moz-placeholder{color:#b9b9b9}
.item{cursor:-webkit-grab;margin-bottom:20px;padding:0 0 20px 20px;display:block;border-bottom:1px solid #ccc;background:rgba(255,255,255,.3);transition:.3s width ease-out,.3s height ease-out}
.item i{margin-right:10px}
.item i,.item p{display:inline-block;vertical-align:middle}
.item p{line-height:1.2;word-break:break-all;width:calc(100% - 50px)}
.is-dropped{transform:scale(0);transition:.2s all ease-out}
.folder{float:left;width:150px;height:150px;background:rgba(0,0,0,0);transition:.2s background-color ease-out;text-align:center}
.folder i.fa-folder{height:90px!important;width:100%!important;line-height:100px!important;margin:10px auto!important;font-size:90px!important;transition:.2s all ease-out}
.folder i.fa-check{color:#fff;background:rgba(0,0,0,.1);border-radius:50%;width:60px;height:60px;text-align:center;line-height:60px;position:absolute;left:0;right:0;top:34px;margin:auto;pointer-events:none;transform:scale(0);opacity:0;font-size:24px}
.folder.item-dropped i.fa-check{animation:animateValidation 1s linear}
@keyframes animateValidation{
0%{transform:scale(1.5);opacity:0}
40%,80%{transform:scale(1);opacity:1}
100%{transform:scale(0);opacity:0}
}
.folder p{cursor:default;opacity:.5;transition:.2s all ease-out}
.folder:hover .fa-folder{transform:scale(1.1)!important}
.folder:hover p{transform:translateY(6px);opacity:1}
.tooltiper .tooltip,.tooltiper-up .tooltip{font-size:.7rem;background:rgba(0,0,0,.7);padding:5px 10px;border-radius:5px;line-height:1.4em;opacity:0}
#folder1 i.fa-folder,#folder1-content h2 .fa-folder{color:#eb4141!important}
#folder2 i.fa-folder,#folder2-content h2 .fa-folder{color:#4bc97a}
#folder3 i.fa-folder,#folder3-content h2 .fa-folder{color:#6fdbeb}
#folder4 i.fa-folder,#folder4-content h2 .fa-folder{color:#eeca4e}
#folder5 i.fa-folder,#folder5-content h2 .fa-folder{color:#5b5b5b}
.tooltiper{position:relative;z-index:3}
.tooltiper .tooltip{min-width:110px;position:absolute;text-align:left;color:#fff;display:block;top:50%;left:120px;transform:translateY(-50%) scale(0);transform-origin:left;transition:transform .2s ease-out,opacity .1s ease-out .1s}
.tooltiper-up .tooltip{min-width:0;position:absolute;text-align:center;color:#fff;display:inline-block;top:-20px;left:50%;transform:translate(-50%,-50%) scale(0);transform-origin:bottom}
.tooltiper-up:hover .tooltip,.tooltiper:hover .tooltip{opacity:1;transition:transform .2s ease-out,opacity .1s ease-out}
.tooltiper:hover .tooltip{transform:translateY(-50%) scale(1)}
.tooltiper-up:hover .tooltip{transform:translate(-50%,-50%) scale(1)}
.tooltiper .tooltip:after{right:100%;top:50%;border:solid transparent;content:" ";height:0;width:0;position:absolute;pointer-events:none;border-right-color:rgba(0,0,0,.7);border-width:4px;margin-top:-4px}
.tooltiper-up .tooltip:after{border-width:7px 7px 0;border-color:rgba(0,0,0,.7) transparent transparent;right:0;left:0;margin:0 auto;top:100%}
.folder-content{display:none;position:absolute;height:420px;width:1012px;background:rgba(255,255,255,.9);z-index:10;box-shadow:0 10px 30px rgba(0,0,0,.1);left:150px;top:315px;border-radius:8px;padding:30px}
.folder-content h2{font-size:21px;padding-bottom:10px;margin-bottom:30px;border-bottom:1px solid #ccc;cursor:default}
.folder-content h2 i{margin-right:10px}
.easeout2{transition:.2s all ease-out}
.folder-content.closed{transform:scale(.8);opacity:0}
.close-folder-content{position:absolute;right:20px;top:20px;background:#f3f3f3;padding:5px 10px;border-radius:5px}
.close-folder-content:hover,.fileUpload span{background:#f95536}
.close-folder-content,.close-folder-content i{transition:.16s all ease-out}
.close-folder-content:hover i{color:#fff}
.folder-content .file{float:left;margin-right:20px;bottom:20px;text-align:center;padding:20px}
.folder-content p{font-size:14px}
.folder-content .file i{font-size:36px;margin-bottom:15px}

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
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Home</a></li>
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
<div class="main">
    <div class="row"><div class="col-md-12" id="continue"></div></div>
    <h1>Available Chapters</h1>
    <br />
    <div class="left">
        <div class="row clearfix" id="loading_chapter">
            <div class="col-lg-12 col-md-12 col-sm-12 px-2 py-2">
                <div class="card px-4 py-4">
                    <div class="header">
                        <h2> <strong>Loading Chapters</strong> <small>This may take a while. Please be Patient.</small> </h2>
                    </div>

                    <div class="body">                        
                        <div class="progress m-b-5">
                            <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <span class="sr-only">Loading In Progress</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="row" id='chapter_list'>
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
        $(document).ready(function() {
            setTimeout(() => {
                $.ajax({
                    type : "get",
                    url : "{{ url()->full() }}",
                    success : function (response) {
                        $("#loading_chapter").fadeOut('fast',function(){
                            $("#chapter_list").html(response);
                        })
                    }
                })
            },3000)

            $.ajax({
                type :"get",
                url : "{{ route('public.offline.public_offline_video_continue_watch') }}",
                success : function (response) {
                    $("#continue").html(response);
                }
            })
        });

        
    </script>
@endsection