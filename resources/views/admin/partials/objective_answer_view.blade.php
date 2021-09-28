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

		.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
			color: #fff;
			background-color: #FF5B5C!important;
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
<div class='modal-body'>
    @foreach ($record->objective_answer as $answers)
            <div class='row'>
                <div class='col-md-0 pr-0'>
                    <h5><strong>Q.</strong></h5>
                </div>
                <div class='col-md-11 pl-0'>
                    <h5>
                        @if($answers->question->question_type == "text")
                            {!! $answers->question->question_title !!}
                        @endif
                    </h5>
                </div>
            </div>
            <div class="row">
                @foreach (json_decode($answers->user_answers) as $all_answers)
                    @if($all_answers->type == "text")
                        <div class='col-md-6'>
                            <div class="funkyradio">
                                <div @if($all_answers->correct && ! $all_answers->user_choice) class="funkyradio-success" @elseif(! $all_answers->correct && $all_answers->user_choice) class="funkyradio-danger" @elseif($all_answers->user_choice && $all_answers->correct) class='funkyradio-success' @endif>
                                    <input type="radio" @if($all_answers->correct) checked @elseif($all_answers->user_choice) checked @endif />
                                    <label style="text-align:center" @if($all_answers->user_choice && $all_answers->correct) class='text-success' @endif> {{ $all_answers->text }}</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($all_answers->type == "image")
                        <div class='col-md-6'>
                            <div class="funkyradio">
                                <div @if($all_answers->correct && ! $all_answers->user_choice) class="funkyradio-success" @elseif(! $all_answers->correct && $all_answers->user_choice) class="funkyradio-danger" @elseif($all_answers->user_choice && $all_answers->correct) class='funkyradio-success' @endif>
                                    <input type="radio" @if($all_answers->correct) checked @elseif($all_answers->user_choice) checked @endif />
                                    <label style="text-align:center" @if($all_answers->user_choice && $all_answers->correct) class='text-success' @endif>
                                        <img src="{{ question_image($all_answers->media) }}" class='img-thumbnail' style="max-width:100px; max-height:100px" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($all_answers->type == "audio")
                        <div class='col-md-6'>
                            <div class="funkyradio">
                                <div @if($all_answers->correct && ! $all_answers->user_choice) class="funkyradio-success" @elseif(! $all_answers->correct && $all_answers->user_choice) class="funkyradio-danger" @elseif($all_answers->user_choice && $all_answers->correct) class='funkyradio-success' @endif>
                                    <input type="radio" @if($all_answers->correct) checked @elseif($all_answers->user_choice) checked @endif />
                                    <label style="text-align:center" @if($all_answers->user_choice && $all_answers->correct) class='text-success' @endif>
                                        <audio controls class='form-control'>
                                            <source src="{{ audio_asset($all_answers->media) }}" type="audio/ogg" />
                                            <source src="{{ audio_asset($all_answers->media) }}" type='audio/mpeg' />
                                        </audio>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class='row mt-2 border-bottom mb-2'>
                <div class='col-md-0 pl-0'>
                    Point Earned: {{ $answers->obtained_marks }}
                </div>
            </div>
    @endforeach
</div>