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
<div class="container-fluid mx-0 px-0">
	
	<div class="row mx-0 px-0" style="position:fixed;width:100%;z-index:9999">
		<div class="col-md-12 bg-danger px-0 mx-0">
			<div class="text-white text-center text-lg">
				Exam will Be Over At
				<span id='demo'> Loading...</span>
				
			</div>
			
		</div>
	</div>


	<form enctype='multipart/form-data' method="post" action="{{ route('public.exam.public_submit_all_answers',[encrypt($question->id)]) }}">
		@csrf
		<div class='row'>
            <div class="col-md-12">
				<x-alert></x-alert>
                <!-- accordian menu -->
                <div class="accordion" id="accordionExample">
                    @foreach ($question->questions as $all_question)
                        @php
                            // check if this question has already been attemped.
                            $attempted_question = \App\Models\UserAnswersSubmit::where('question_id',$all_question->id)
													->where('user_login_id',auth()->id())
													->first();
                        @endphp
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0 ">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#question_{{$all_question->id}}" aria-expanded="true" aria-controls="collapseOne">
                                    <span class='text-danger'>{{ $loop->index+1 }}</span>.  
                                    @php
                                        echo strip_tags($all_question->question_title);
                                    @endphp                                
                                </button>
                            </h2>
                        </div>

                        <div id="question_{{$all_question->id}}" class="collapse @if($loop->index+1 == 1) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                @if($all_question->question_structure == "subjective")
									@if($attempted_question && ! $attempted_question->draft)
										<div class='form-control py-2'> {!! $attempted_question->subjective_answer !!} </div>
									@else
										<textarea 
											name='subjective_answer[{{ $all_question->id }}]'
										>@if($attempted_question && $attempted_question->draft){{$attempted_question->subjective_answer}}@endif</textarea>
										@if( $attempted_question && $attempted_question->subjective_answer_upload && ! $attempted_question->draft)
											<p class="text-warning">
												You have already uploaded a file. <br />
											</p>
										@else
											<hr />
											<label class='label-control'>Select Image / Audio File</label><br />
											<input type="file" name="answer_file[{{ $all_question->id }}]"  />
											<div class="col-md-12">
												<p class="text-right">
													<button type="submit" formaction="{{ route('public.exam.public_submit_answer_as_draft',[encrypt($question->id),'q_id'=>$all_question->id]) }}" class='btn btn-dark btn-sm'>Save As Draft</button>
													<button type="submit" formaction="{{ route('public.exam.public_submit_single_answer',[encrypt($question->id),'q_id'=>$all_question->id]) }}" class='btn btn-info btn-sm submit_button'>Submit</button>
												</p>
											</div>
										@endif
									@endif
                                    
                                @elseif($all_question->question_structure == "objective")
                                    @php
                                        $answers = json_decode($all_question->objectives);
                                        // dd($answers);
                                        if($attempted_question) {
                                            $user_answer = json_decode($attempted_question->user_answers);
                                        }
                                    @endphp
                                    <div class="row">
                                        @foreach ($answers as $key => $objective_answer)
                                            @if($objective_answer->type == "text")
                                                <div class='col-md-6'>
                                                    <div class="funkyradio">
                                                        <div class="funkyradio-success">
                                                            <input type="radio" @if($attempted_question && ! $attempted_question->draft) disabled @endif @if( $attempted_question && $user_answer[$key]->user_choice == true) checked @endif name="objective_answer[{{ $all_question->id }}]" value="{{ $key }}" id="{{ $objective_answer->text }}" />
                                                            <label style="text-align:center" for="{{ $objective_answer->text }}"> {{ $objective_answer->text }}</label>
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
										<div class="col-md-12">
											<p class="text-right">
												<button type="submit" formaction="{{ route('public.exam.public_submit_answer_as_draft',[encrypt($question->id),'q_id'=>$all_question->id]) }}" class='btn btn-dark btn-sm'>Save As Draft</button>
												<button type="submit" formaction="{{ route('public.exam.public_submit_single_answer',[encrypt($question->id),'q_id'=>$all_question->id]) }}" class='btn btn-info btn-sm submit_button'>Submit</button>
											</p>
										</div>

                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                <!-- accordian menu -->

            </div>

            <!-- <div class='col-md-12 mt-2'>
                <button type="submit" class='btn btn-info btn-block'>
                    Submit My Answer / उत्तर बुझाउनुहोस 
                </button>
            </div> -->
		</div>
	</form>
</div>
@endsection


@section("page_js")
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
				$('.submit_button').remove();
				clearInterval(x);
				document.getElementById(elId).innerHTML = "EXPIRED";
			}
			}, 1000);
		}
	</script>
    <script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- <script>
			tinymce.init({
			selector: 'textarea',
			plugins: 'lists image print preview hr',
			toolbar_mode: 'floating',
			menubar: false
		});
	</script> -->
		@php
			$expire_date = date("M d, Y",strtotime($question->exam_end_date)) . " 24:00:00";
		@endphp
		<script>
		countTimeDown("demo","{{ $expire_date }}",".submit_button")
	</script>
@endsection