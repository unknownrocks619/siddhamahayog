@php
        $leader = \App\Models\UserFamilyGroup::where('leader_id',auth()->user()->user_detail_id)
                            ->where('approved',true)
							->with(["member_detail"])
                            ->where('sibir_record_id',$record->sibir_record_id)
                            ->get();
@endphp
@if($leader->count())
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
@endif
@if ($leader->count())
    <form method="post" id="zoom_attendancce" action="{{ route('public.event.public_make_group_attendance',[encrypt($record->sibir_record_id),'zone_attendance'=>true,'c_id'=>$record->country_id]) }}">
    @csrf
    <div class='modal-header'>
        <h5 class='modal-title'>Attendance for `<span class='text-danger'>{{ $record->sibir->sibir_title }}</span>`</h5>
    </div>
    <div class='modal-body'>
        @php
           // if (! $leader ) {
             //   echo "<p class='text-primary'>Please Wait...redirecting to zoom session.</p>";   
            // } else{
                echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                        echo "<div id='message'></div>";
                    echo "</div>";
                echo "</div>";
                echo "<p class='text-info'>Please Check all member who will attend with you in this session.</p>";
                echo "<div class='bs-callout bs-callout-primary' style='padding-left:0px'>";

                    echo "<ul style='list-style-type:none'>";
                        echo "<div class='row'>";
                            foreach ($leader as $member) {
                                echo "<div class='col-md-6'>";
                                    echo "<li class=''>";
                                        echo "<div class='funkyradio'>";
                                            echo "<div class='funkyradio-success'>";
                                                echo "<input type='checkbox'";
                                                 if($member->status) { echo "checked" ;} else { echo "disabled" ; }
                                                echo "  name='member[]' id='{$member->id}' value='".encrypt($member->member_id)."' />";
                                                echo "<label for='{$member->id}'>";
                                                    echo $member->member_detail->full_name();
                                                echo "</label>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</li>";
                                echo "</div>";
                            }
                        echo "</div>";
                    echo "</ul>";
                echo "</div>";
            //}
        @endphp 
    </div>
    <div class='modal-footer'>
        <button type="submit" class='btn btn-primary'> Join With Group</button>
    </div>

    <script>
        $("form#zoom_attendancce").submit(function(event){
            event.preventDefault();
            $("#message").fadeIn('fast',function(){
                $(this).empty();
                $(this).removeAttr('class');
            })
            $.ajax({
                type : $(this).attr('method'),
                url : $(this).attr('action'),
                data : $(this).serializeArray(),
                success : function( response ) {
                    if (response.success == true ) {
                        $("#message").attr("class",'alert alert-success');
                    } else {
                        $("#message").attr("class",'alert alert-danger');
                    }
                    $("#message").attr('medium',function() {
                        $(this).html(response.message);
                    });

                    if (response.success == true) {
						window.location.href= response.join_url;
                    }
                },
                error : function(response) {
					
                }
            })
        })
    </script>
@else
    <div class='modal-header'>
        <h5 class='modal-title'>Attendance for `<span class='text-danger'>{{ $record->sibir->sibir_title }}</span>`</h5>
    </div>
    <div class='modal-body'>
        <p class='text-primary' id="attendance_message">Please Wait...validating your current session.</p>   
    </div>
	<div class='modal-footer'>
		<a href='#' class='btn btn-secondary disabled action'>Join Now</a>
	</div>
    <script>
        // directly load without any waiting..
        $(document).ready(function(){
            $.ajax({
                type : "post",
                data : "attendance=true&c_id={{$record->country_id}}&zone_attendance=true",
                url : "{{ route('public.event.public_make_single_attendance',[encrypt($record->sibir_record_id)]) }}",
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function (response) {
                    if (response.success == true ) {
                        $("#attendance_message").attr("class",'alert alert-success');
						$(".action").attr("href",response.join_url).attr('target','_blank');
						$('.action').removeClass("disabled").removeClass('btn-secondary').addClass('btn-primary')
                    } else {
                        $("#attendance_message").attr("class",'alert alert-danger');
						$(".action").attr("href","#").removeAttr('target');
						$('.action').addClass("disabled").addClass('btn-secondary').removeClass('btn-primary');
                    }
                    $("#attendance_message").attr('medium',function() {
                        $(this).html(response.message);
                    });

                    if (response.success == true && response.join_url) {
                        // let arrange_data = response._protocal + "://us05web."+atob(response._p_key)+"?action=join&confno="+atob(response._action)+"&pwd="+atob(response._token);
                        window.location.href = response.join_url;
						// location.reload();
                    }
                }

            })
        })
    </script>
@endif