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
                            <li class='breadcrumb-item'><a href=" {{ route('public.room.public_my_room_bookings') }} ">Room</a></li>
                            <li class="breadcrumb-item active" aria-current='active'>
                                History
                            </li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Booking / Reservation History</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection


@section("content")
    <div class="container-fluid" style='padding-left:0px'>
		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px;">
				@include("public.inc.navigation")
			</div>
			
            <div class="col-md-7 col-lg-8 col-xl-9">
                <x-alert></x-alert>
                <div class='card'>
                    <div class='card-header'>
                        <a href="{{ route('public.room.public_my_room_bookings') }}" class='btn btn-sm btn-success'><i class='fas fa-arrow-left'></i> &nbsp; Go Back</a>
                    </div>
                    <div class='card-body'>
                        <table class='table table-hover table-bordered'>
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Room Detail</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td> {{ $loop->index+1 }} </td>
                                        <td> {{ date("Y-m-d",strtotime($booking->check_in_date)) }} </td>
                                        <td> @if ($booking->check_out_date) {{ date("Y-m-d",strtotime($booking->check_out_date)) }}  @endif </td>
                                        <td> {{ $booking->room->room_name }} </td>
                                        <td> @if($booking->is_occupied) 
                                                <span class='bg-success px-2'>Booked</span> 
                                            @elseif($booking->is_reserved) 
                                                <span class='bg-warning px-2'>Reserved</span> 
                                            @elseif ($booking->status == "Reservation Cancelled")
                                                <span class='bg-warning px-2'>Cancelled</span>
                                            @elseif($booking->status == "Out")
                                                <span class='bg-success px-2'>Checked Out</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection