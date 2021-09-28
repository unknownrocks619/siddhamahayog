@extends("layouts.clients")

@section("page_css")
	<style>
		/*page styling*/
		.bs-callout {
			-moz-border-bottom-colors: none;
			-moz-border-left-colors: none;
			-moz-border-right-colors: none;
			-moz-border-top-colors: none;
			border-color: #eee;
			border-image: none;
			border-radius: 3px;
			border-style: solid;
			border-width: 1px 1px 1px 5px;
			margin-bottom: 5px;
			padding: 20px;
		}
		.bs-callout:last-child {
			margin-bottom: 0px;
		}
		.bs-callout h4,
		.bs-callout h5 {
			margin-bottom: 10px;
			margin-top: 0;
			font-weight: 600;
		}

		.bs-callout-danger {
			border-left-color: #d9534f;
		}

		.bs-callout-danger h4,
		.bs-callout-danger h5{
			color: #d9534f;
		}

		.bs-callout-primary {
			border-left-color: #0d6efd!important;
		}

		.bs-callout-primary h4,
		.bs-callout-primary h5{
			color: #0d6efd!important;
		}

		.header-title {
			color: #fff;
		}
		.title-thin {
			font-weight: 300;
		}
		.service-item {
			margin-bottom: 30px;
		}

		blockquote
		{
			font-size: 80% !important;
			page-break-inside: avoid;
			border: 3px solid #fff;
			width: 80%;
			-webkit-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
				-mox-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
				-ms-box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
					box-shadow: inset 5px 0px 0px 0px #f60, 0px 0px 0px 0px #888;
			
			padding: 10px 20px;
			margin: 0 0 20px;
			font-size: 17.5px;
			border-left: none;
		}
		.funkyradio div {
			clear: both;
			overflow: hidden;
		}

		.funkyradio label {
			width: 100%;
			border-radius: 3px;
			border: 1px solid #D1D3D4;
			font-weight: normal;
		}

		.funkyradio input[type="radio"]:empty,
		.funkyradio input[type="checkbox"]:empty {
			display: none;
		}

		.funkyradio input[type="radio"]:empty ~ label,
		.funkyradio input[type="checkbox"]:empty ~ label {
			position: relative;
			line-height: 2.5em;
			text-indent: 3.25em;
			margin-top: 2em;
			cursor: pointer;
			-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
					user-select: none;
		}

		.funkyradio input[type="radio"]:empty ~ label:before,
		.funkyradio input[type="checkbox"]:empty ~ label:before {
			position: absolute;
			display: block;
			top: 0;
			bottom: 0;
			left: 0;
			content: '';
			width: 2.5em;
			background: #D1D3D4;
			border-radius: 3px 0 0 3px;
		}

		.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
		.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
			color: #888;
		}

		.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
		.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
			content: '\2714';
			text-indent: .9em;
			color: #C2C2C2;
		}

		.funkyradio input[type="radio"]:checked ~ label,
		.funkyradio input[type="checkbox"]:checked ~ label {
			color: #777;
		}

		.funkyradio input[type="radio"]:checked ~ label:before,
		.funkyradio input[type="checkbox"]:checked ~ label:before {
			content: '\2714';
			text-indent: .9em;
			color: #333;
			background-color: #ccc;
		}

		.funkyradio input[type="radio"]:focus ~ label:before,
		.funkyradio input[type="checkbox"]:focus ~ label:before {
			box-shadow: 0 0 0 3px #999;
		}

		.funkyradio-default input[type="radio"]:checked ~ label:before,
		.funkyradio-default input[type="checkbox"]:checked ~ label:before {
			color: #333;
			background-color: #ccc;
		}

		.funkyradio-primary input[type="radio"]:checked ~ label:before,
		.funkyradio-primary input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #337ab7;
		}

		.funkyradio-success input[type="radio"]:checked ~ label:before,
		.funkyradio-success input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #5cb85c;
		}

		.funkyradio-danger input[type="radio"]:checked ~ label:before,
		.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #d9534f;
		}

		.funkyradio-warning input[type="radio"]:checked ~ label:before,
		.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #f0ad4e;
		}

		.funkyradio-info input[type="radio"]:checked ~ label:before,
		.funkyradio-info input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #5bc0de;
		}

		.loader {
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 1;
			width: 120px;
			height: 120px;
			margin: -76px 0 0 -76px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
			background: radial-gradient(#d83737,#9a9e5b)
		}

		@keyframes  spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		
		.base-timer {
			position: relative;
			width: auto;
			height: 300px;
		}

		.base-timer__svg {
			transform: scaleX(-1);
		}

		.base-timer__circle {
			fill: none;
			stroke: none;
		}

		.base-timer__path-elapsed {
			stroke-width: 7px;
			stroke: grey;
		}

		.base-timer__path-remaining {
			stroke-width: 7px;
			stroke-linecap: round;
			transform: rotate(90deg);
			transform-origin: center;
			transition: 1s linear all;
			fill-rule: nonzero;
			stroke: currentColor;
		}

		.base-timer__path-remaining.green {
			color: rgb(65, 184, 131);
		}

		.base-timer__path-remaining.orange {
			color: orange;
		}

		.base-timer__path-remaining.red {
			color: red;
		}

		.base-timer__label {
			position: absolute;
			width: 140px;
			height: 140px;
			top: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 48px;
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
								<li class="breadcrumb-item"><a href="{{route('public_user_dashboard')}}">Home</a></li>
								<li class="breadcrumb-item"><a href="{{ route('public.exam.public_examination_list') }}">Exam / Evaulation</a></li>
								<li class="breadcrumb-item active" aria-current="page">{{ $question->question_term }}</li>
							</ol>
						</nav>
						<h2 class="breadcrumb-title">{{ $question->question_term }}</h2>
					</div>
				</div>
			</div>
		</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
<div class="container-fluid">
	<form @if($qts->question_structure == "subjective") enctype='multipart/form-data' @endif method="post" action="{{ route('public.exam.public_submit_answer',[encrypt($question->id),$qts->id]) }}">
		@csrf
		<div class='row'>
			<div class='col-md-10 col-lg-10 col-sm-12'>
				@php
					$question = $qts;
				@endphp
					<div class='bs-callout @error("gender") bs-callout-danger @else bs-callout-primary @enderror'>
						<h4 class=' mt-4 pt-4'>
							@if($question->question_title)
								{!! $question->question_title !!}
							@endif

							@if($question->question_type == "audio")
								<audio controls class='form-control'>
									<source src="{{ audio_asset($question->alternate_question_title) }}" type="audio/ogg" />
									<source src="{{ audio_asset($question->alternate_question_title) }}" type="audio/mpeg" />
								</audio> 
							@endif

							@if ($qts->question_type == "image")
								<img src="{{question_image($qts->alternate_question_title)}}" class='img-thumbanil' style='max-width:450px ;max-height:450px;' />
							@endif
						</h4>
						<p>Total Marks:  {{ $question->total_point }} </p>
						<div class='row'>
							@if($question->question_structure == "subjective")
								<div class='col-md-12 col-sm-12'>
									<textarea class="form-control" name='answer'></textarea>
								</div>
								<div class='col-md-6 mt-2'>
									<label  class='label-control'>Select Image / Audio</label>
									<input type='file' class='form-control' name='file' /> 
								</div>
							@endif
							@if($question->question_structure == "objective")
								@php
									$answers = json_decode($question->objectives);
								@endphp
								@foreach ($answers as $key => $objective_answer)
									@if($objective_answer->type == "text")
										<div class='col-md-6'>
											<div class="funkyradio">
												<div class="funkyradio-success">
													<input type="radio" name="answer" value="{{ $key }}" id="{{ $objective_answer->text }}" />
													<label style="text-align:center" for="{{ $objective_answer->text }}"> {{ $objective_answer->text   }}</label>
												</div>
											</div>
										</div>
									@endif
									@if($objective_answer->type == "audio")
										<div class='col-md-6'>
											<div class="funkyradio">
												<div class="funkyradio-success">
													<input type="radio" name="answer" value="{{ $key }}" id="{{ $objective_answer->media ?? $loop->index }}" />
													<label for="{{ $objective_answer->media ?? $loop->index }}"> 
														<audio controls>
															<source src="{{ audio_asset($objective_answer->media) }}" type="audio/ogg" />
															<source src="{{ audio_asset($objective_answer->media) }}" type="audio/mpeg" />
														</audio>
													</label>
												</div>
											</div>
										</div>
									@endif
									@if($objective_answer->type == "image")
										<div class='col-md-6'>
											<div class="funkyradio">
												<div class="funkyradio-success">
													<input type="radio" name="answer" value="{{ $key }}" id="{{ $objective_answer->media ?? $loop->index }}" />
													<label for="{{ $objective_answer->media ?? $loop->index }}">
														<img src='{{question_image($objective_answer->media)}}' style="max-width:479px ;max-height:347px;" class='img-thumbnail' />
													</label>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							@endif
						</div>
					</div>

					<div class='row'>
						<div class="col-md-10 text-center">
						<button type="submit" class='btn btn-lg btn-primary'>Continue >></button>
						</div>
					</div>
			</div>

			<div class='col-lg-2 col-md-2 d-none-sm'>
				<div class='card'>
					<div class='card-header'>
						<h4>Progress</h4>
					</div>
					<div class='card-body'>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection


@section("page_js")
	@if($qts->question_structure == "subjective")

		<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	@endif
	
	@if($qts->question_structure == "subjective")
	<script>
			tinymce.init({
			selector: 'textarea',
			plugins: 'lists image print preview hr',
			toolbar_mode: 'floating',
			menubar: false
		});
	</script>
	@endif
@endsection