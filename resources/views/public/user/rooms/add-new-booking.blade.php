@extends("layouts.clients")

@section("page_css")
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Dashboard</a></li>
                            <li class='breadcrumb-item'><a href="{{ route('public.room.public_my_room_bookings') }}">Room</a>
                            <li class='breadcrumb-item active' aria-current="page">New Booking</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Book Room</h2>
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
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px;">
				@include("public.inc.navigation")
			</div>            
            <div class="col-md-7 col-lg-8 col-xl-9">
                <form method="post" action="{{ route('public.room.public_check_room_avaibility') }}">
                    @csrf
                    <div class='card'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class='label-control'>Select Room<span class='text-danger'>*</span></label>
                                    <select class='form-control' name='room'>
                                        @php
                                            $rooms = \App\Models\Room::select(['room_name','id'])->get();
                                            foreach ($rooms as $room):
                                                echo "<option value='{$room->id}'>";
                                                    echo $room->room_name;
                                                echo "</option>";
                                            endforeach;
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class='row mt-4'>
                                <div class='col-md-6'>
                                    <label class='label-control'>Select Visit Date<span class='text-danger'>*</span></label>
                                    <input type="date" class='form-control' required  name='visit_date' />
                                </div>
                                <div class='col-md-6'>
                                    <label class='label-control'>How long are you going to stay (in days)<span class='text-danger'>*</span></label>
                                    <input type="number" class='form-control' required name="total_staying" />
                                </div>
                            </div>
                        </div>
                        <div class='card-body' id='booking_confirmation'>
                            <button type="submit" class='btn btn-primary'>Check Avaibility</button>
                            <a href="{{ route('public.room.public_my_room_bookings') }}" class='btn btn-sm btn-primary'>Cancel</a>
                        </div>
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
                $("#loading_text").html("Please wait... Checking Avaibility.. ");
            });
        });

        $(document).ajaxStop( function() {
            $("#overlay").fadeOut(function() {
                $("#loading_text").html('Please wait... Connecting to server...');
            });
        });
    </script>

    <script type="text/javascript">
        $("form").submit(function(event) {
            event.preventDefault();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
                type : "POST",
                data : $(this).serializeArray(),
                url : $(this).attr('action'),
                success : function (response) {
                    $("#booking_confirmation").html(response)
                }
            });
        })
    </script>
@endsection