<!-- Menu -->
<div class="sigma_header-inner">
    <div class="sigma_header-top">
        <div class="sigma_header-top-inner">
            <ul class="sigma_header-top-links">
                @if(site_settings('main_contact'))
                <li class="menu-item">
                    <a href="tel:+123456789">
                        <i class="fal fa-phone"></i>
                        {{ site_settings("main_contact") }}
                    </a>
                </li>
                @endif
                @if(site_settings('official_email'))
                <li class="menu-item">
                    <a href="mailto:{{ site_settings('official_email') }}">
                        <i class="fal fa-envelope"></i> {{ site_settings('official_email') }}
                    </a>
                </li>
                @endif
            </ul>


            <ul class="navbar-nav">
                @foreach (menus() as $menu )
                @if($menu->menu_position == "top" && $menu->display_type == "public" && $menu->active )
                <li class="menu-item @if(menus()->where('parent_menu',$menu->id)->count()) menu-item-has-children @endif">
                    <a href="{{-- route('slug',$menu->slug) --}}">
                        {{ $menu->menu_name }}
                    </a>
                    @if(menus()->where('parent_menu',$menu->id)->count() )
                    <ul class="sub-menu">
                        @foreach (menus()->where('parent_menu',$menu->id) as $child_menu)
                        <li class="menu-item">
                            <a href="{{-- route('slug',$menu->slug) --}}">
                                @if($child_menu->active && $child_menu->display_type == "public")
                                {{ $child_menu->menu_name }}
                                @endif
                            </a>
                        </li>

                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
                @endforeach
            </ul>
            <ul class="sigma_header-top-links">
                @if(site_settings('live_show') )
                <li class="d-flex align-items-center">
                    <a href="#" class="live">
                        <i class="fa fa-circle"></i>
                        Live
                    </a>
                </li>
                @endif

                @auth

                <li class="menu-item menu-item-has-children d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger signma_btn-custom">Logout</button>
                    </form>
                </li>
                <li class="ms-3 menu-item menu-item-has-children d-flex align-items-center">
                    <form method="get" action="{{ route('dashboard') }}">
                        <button type="submit" class="btn btn-sm btn-outline-primary signma_btn-custom">
                            <img src="{{ profile() }}" style="width:25px; height:25px;border-radius:50%;border:2px solid " class="img-circle border border-danger" />
                            Dashboard
                        </button>
                    </form>
                </li>
                @else
                <li class="menu-item menu-item-has-children d-flex align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-info bg-info sigma_btn-custom"> Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-warning bg-warning sigma_btn-custom">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-center justify-content-lg-between">
        <ul class="navbar-nav">

            @foreach (menus() as $menu)
            @if($menu->menu_position == "main_menu" && ! $menu->parent_menu && $menu->active && $menu->display_type == "public")
            <li class="menu-item @if(menus()->where('parent_menu',$menu->id)->count()) menu-item-has-children @endif">
                <a href="{{-- route('slug',$menu->slug) --}}">
                    {{ $menu->menu_name }}
                </a>
                @if(menus()->where('parent_menu',$menu->id)->count())
                <ul class="sub-menu">
                    @foreach (menus()->where('parent_menu',$menu->id)->where('active',true)->where('display_type','public') as $child_menu)
                    <li class='menu-item @if(menus()->where("parent_menu",$child_menu->id)->count()) menu-item-has-children @endif'>
                        <a href="{{-- route('slug',$child_menu->slug) --}}">
                            {{ $child_menu->menu_name }}
                        </a>
                        @if(menus()->where("parent_menu",$child_menu->id)->count())
                        <ul class="sub-menu">
                            @foreach (menus()->where('parent_menu',$child_menu->id)->where('active',true)->where('display_type','public') as $two_level)
                            <li class="menu-item">
                                <a href="">
                                    {{ $two_level->menu_name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endif

            @endforeach
            <li class="menu-item menu-item-has-children">
                <a href="#">
                    program
                </a>
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('sadhana.detail') }}">
                            Sadhana
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('vedanta.index') }}">
                            Vedanta Darshan
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>