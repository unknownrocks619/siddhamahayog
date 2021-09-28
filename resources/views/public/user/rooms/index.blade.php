@extends("layouts.clients")

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
                            <li class='breadcrumb-item active' aria-current="page">Room</li>>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Room Booking / Avaibility</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
<div class="container-fluid" style="padding-left:0px">
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px;padding-right:0px;">
				@include("public.inc.navigation")
			</div>
			
            <div class="col-md-7 col-lg-8 col-xl-9">
                <x-alert></x-alert>
                <a href="{{ route('public.room.public_add_new_room_bookings') }}" class='btn btn-sm btn-primary mb-2'> <i class='fas fa-plus'></i> Create New Reservation</a>
                <a href="{{ route('public.room.public_user_booking_history') }}" class='btn btn-sm btn-secondary mb-2 float-sm-right'><i class='fas fa-clock'></i> Booking Record</a>
                @if($bookings->count())
                <div class='card'>
                    <div class='card-body'>
                        <table class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td> {{ $booking->room->room_name }} </td>
                                        <td> {{ date("Y-m-d",strtotime($booking->check_in_date)) }} </td>
                                        <td> @if($booking->check_out_date) {{ date("Y-m-d", strtotime($booking->check_out_date)) }} @else Not Available @endif </td>
                                        <td>
                                            @if($booking->is_reserved)
                                                <span class='bg-primary-light px-2'>Reserved</span>
                                            @elseif ($booking->is_occupied)
                                                <span class='bg-success-light px-2'>Booked</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(! $booking->is_occupied)
                                            <form method="post" action="{{ route('public.room.public_clear_reservation_user',encrypt($booking->id)) }}">
                                                @csrf
                                                <button onclick="return confirm('You are about to clear your reservation. This action cannot be undone. Do you wish to continue ?')" type="submit" class='btn btn-sm btn-danger'><i class='fas fa-trash'></i> &nbsp; Remove Reservation</button>
                                            </form>
                                            @else
                                                <span class='text-success'>Check out available only at property</span>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                    <div class='card'>
                        <div class='card-body'>
                            <h4>No Booking Available. <a href="{{ route('public.room.public_add_new_room_bookings') }}" class='btn btn-sm btn-primary'><i class='fas fa-plus'></i> Create New Reservation</a></h4>
                        </div>
                    </div>
                @endif
            </div>
		</div>

	</div>

@endsection