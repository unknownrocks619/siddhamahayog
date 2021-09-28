<!-- Profile Sidebar -->
@php
   // $user_detail = \App\Models\userDetail::findOrFail(auth()->user()->user_detail_id);
   $user_detail = auth()->user()->userdetail;
@endphp
<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                @if($user_detail->profile_id)
                    <img src="{{ profile_asset ($user_detail->profile_id) }}" alt="{{ $user_detail->full_name() }}">
                @else
                    <img src="{{ asset ('gp/gurudev_login.jpeg') }}" alt="Guru Dev">
                @endif
            </a>
            <div class="profile-det-info">
                <h3>
                    
                    {{ $user_detail->full_name() }}
                </h3>
            </div>
        </div>
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
        <ul>
            <li @if(request()->route()->getName() == "public_user_dashboard") class='active' @endif>
                <a href="{{ route('public_user_dashboard') }}">
                    <i class="fas fa-columns"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li @if(request()->route()->getName() == "public.public_profile_display") class='active' @endif>
                <a href="{{ route('public.public_profile_display') }}" >
                    <i class="fas fa-columns"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li @if(request()->route()->getName() == "public.public_subscription") class='active' @endif>
                <a href="{{ route('public.public_subscription') }}" >
                    <i class="fas fa-columns"></i>
                    <span>My Subscription</span>
                </a>
            </li>
            <li @if(request()->route()->getName() == "public.exam.public_examination_list") class='active' @endif>
                <a href="{{ route('public.exam.public_examination_list') }}" >
                    <i class="fas fa-columns"></i>
                    <span>Exam / Evaulation</span>
                </a>
            </li>
            <li class="{{ areActiveRoutes(['public.room.public_my_room_bookings','public.room.public_add_new_room_bookings','public.room.public_user_booking_history'],'active') }}">
                <a href="{{ route('public.room.public_my_room_bookings') }}" >
                    <i class="fas fa-columns"></i>
                    <span> Book A Room </span>
                </a>
            </li>
            <li class="{{ areActiveRoutes(['public.room.public_my_room_bookings','public.room.public_add_new_room_bookings','public.room.public_user_booking_history'],'active') }}">
                <a href="{{ route('public.room.public_my_room_bookings') }}" >
                    <i class="fas fa-columns"></i>
                    <span>Settings</span>
                </a>
            </li>
            
            <li>
                <form method="post" action="{{ route('public_user_logout_button') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger pl-3 ml-1">
                        <i class='fas fa-sign-out-alt'></i> Logout
                    </button>
                </form>
            </li>
        </ul>
        </nav>
    </div>
</div>
<!-- /Profile Sidebar -->