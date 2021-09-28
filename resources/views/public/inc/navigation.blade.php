<!-- Profile Sidebar -->

@php
   // $user_detail = \App\Models\userDetail::findOrFail(auth()->user()->user_detail_id);
   // dd(\Cache::store('file')->get('u_d'));
   $user_detail =  auth()->user()->userdetail;
   //dd($user_detail->pro);
@endphp
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#"></a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">

            @if($user_detail->profile_id)
            <img src="{{ profile_asset ($user_detail->profile_id) }}" alt="{{ $user_detail->full_name() }}">

            @else
            <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
            alt="User picture">
            @endif
        </div>
        <div class="user-info">
          <span class="user-name">{{ $user_detail->first_name }}
            <strong>{{ $user_detail->last_name }}</strong>
          </span>
          <span class="user-role">
            @if(auth()->user()->user_type == "public")
              General
            @else
              {{ ucwords(auth()->user()->user_type) }}
            @endif  
          |
            <form method="post" action="{{ route('public_user_logout_button') }}" class="d-inline-block">
              @csrf
              <button type="submit" class='btn btn-link text-danger mx-0 px-0'>Logout</button>
            </form> 
          <span class="user-status d-block">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
     
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li class="{{ isActive('public_user_dashboard','active') }}">
            <a href="{{ route('public_user_dashboard') }}">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-dropdown {{ areActiveRoutes(['public.public_subscription'],'active') }}">
            <a href="#" >
              <i class="fa fa-shopping-cart"></i>
              <span>Events</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu" @if(areActiveRoutes(['public.public_subscription','public.family.public_event_family_list','public.family.public_add_family_to_event','public.event.public_list_my_absent_record','public.event.public_request_absent_form'],true)) style="display:block" @endif>
              <ul>
                <li>
                  <a href="{{ route('public.public_subscription') }}" class="{{ isActive('public.public_subscription','text-white') }}">
                        My Program
                  </a>
                </li>
                <li>
                  <a href="{{ route('public.family.public_event_family_list') }}" class="{{ isActive('public.family.public_event_family_list','text-white') }} {{ isActive('public.family.public_add_family_to_event','text-white') }}">My Family / Group</a>
                </li>
                <li>
                  <a href="{{ route('public.event.public_list_my_absent_record') }}" class="{{ isActive('public.event.public_list_my_absent_record','text-white') }} {{ isActive('public.event.public_request_absent_form','text-white') }}">Absent Form</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown {{ areActiveRoutes(['public.exam.public_examination_list','public.room.public_my_room_bookings'],'active') }}">
            <a href="#">
                <i class="fa fa-chart-line"></i>
              <span>Activity</span>
            </a>
            <div class="sidebar-submenu" @if(areActiveRoutes(['public.exam.public_examination_list','public.room.public_my_room_bookings'],true)) style="display:block" @endif>
              <ul>
                <li>
                  <a href="{{ route('public.exam.public_examination_list') }}" class="{{ isActive('public.exam.public_examination_list','text-white') }}">Question / Answer</a>
                </li>
                <li>
                  <a class="{{ isActive('public.room.public_my_room_bookings','text-white') }}" href="{{ route('public.room.public_my_room_bookings') }}">Bookings</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown {{ areActiveRoutes(['public.public_profile_display'],'active') }}">
            <a href="#">
              <i class="fa fa-gear"></i>
              <span>Settings</span>
            </a>
            <div class="sidebar-submenu" @if(areActiveRoutes(['public.profile.public_profile_display','public.profile.public_personal','public.profile.public_profile_password'],true)) style="display:block" @endif>
              <ul>
                <li>
                  <a href="{{ route('public.profile.public_profile_display') }}" class="{{ isActive('public.profile.public_profile_display','text-white') }}">Profile</a>
                </li>
                <li>
                  <a href="{{ route('public.profile.public_personal') }}" class="{{ isActive('public.profile.public_personal','text-white') }}">Personal</a>
                </li>
                <li>
                  <a href="{{ route('public.profile.public_profile_password') }}" class="{{ isActive('public.profile.public_profile_password','text-white') }}">Password</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="header-menu">
            <span>Extra</span>
          </li>
          <li>
            <a href="{{ route('public.live.public_live_program_list') }}" class="{{ isActive('public.live.public_live_program_list','text-white') }}">
              <i class="fa fa-book"></i>
              <span>Program</span>
              <span class="badge badge-pill badge-danger">Live</span>
            </a>
          </li>
          <li>
            <a href="{{ route('public.offline.public_get_offline_videos') }}" class="{{ isActive('public.offline.public_get_offline_videos','text-white') }}">
              <i class="fa fa-calendar"></i>
              <span>Offline Recording</span>
            </a>
          </li>
          <!-- <li>
            <a href="#">
              <i class="fa fa-folder"></i>
              <span>Feedback</span>
            </a>
          </li> -->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <!-- <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a> -->
      <form method="post" action="{{ route('public_user_logout_button') }}" class="mx-0 px-0" style="text-align:center;flex-grow:1;">
        @csrf
        <button type="submit" class='btn btn-link text-danger mx-0 px-0'>
          <i class='fa fa-power-off'></i>
        </button>
      </form> 
    </div>
  </nav>
</div>
<!-- /Profile Sidebar -->