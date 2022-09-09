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
          <a href="">
            {{ $menu->menu_name }}
          </a>
          @if(menus()->where('parent_menu',$menu->id)->count() )
          <ul class="sub-menu">
            @foreach (menus()->where('parent_menu',$menu->id) as $child_menu)
            <li class="menu-item">
              <a href="#">
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

        <li class="menu-item menu-item-has-children d-flex align-items-center">
          <a href="{{ route('login') }}" class="btn btn-sm btn-info bg-info sigma_btn-custom"> Sign In</a>
          <a href="{{ route('register') }}" class="btn btn-sm btn-warning bg-warning sigma_btn-custom">Register</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="d-flex justify-content-center justify-content-lg-between">
    <ul class="navbar-nav">
      @foreach (menus() as $menu)
      @if($menu->menu_position == "main_menu" && ! $menu->parent_menu && $menu->active && $menu->display_type == "public")
      <li class="menu-item @if(menus()->where('parent_menu',$menu->id)->count()) menu-item-has-children @endif">
        <a href="">
          {{ $menu->menu_name }}
        </a>
        @if(menus()->where('parent_menu',$menu->id)->count())
        <ul class="sub-menu">
          @foreach (menus()->where('parent_menu') as $child_menu)
          @if($child_menu->active && $menu->display_type == "public")
          <li class="menu-item">
            <a href="">
              {{ $child_menu->menu_name }}
            </a>
          </li>
          @endif
          @endforeach
        </ul>
        @endif
      </li>
      @endif

      @endforeach
    </ul>
    <div class="sigma_header-controls style-2 p-0 border-0">
      <ul class="sigma_header-controls-inner pe-3">

        <li class="sigma_header-cart style-2">
          <a href="cart.html"> <i class="fal fa-shopping-bag"></i> </a>
          <span class="number">1</span>
          <ul class="cart-dropdown">
            <li>
              <a href="#" class="sigma_cart-product-wrapper">
                <img src="assets/img/products/1.jpg" alt="prod1">
                <div class="sigma_cart-product-body">
                  <h6>Gita Book</h6>
                  <div class="sigma_product-price justify-content-start">
                    <span>29$</span>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <a href="#" class="sigma_cart-product-wrapper">
                <img src="assets/img/products/5.jpg" alt="prod1">
                <div class="sigma_cart-product-body">
                  <h6>Ramayana Book</h6>
                  <div class="sigma_product-price justify-content-start">
                    <span>35$</span>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <a href="#" class="sigma_cart-product-wrapper">
                <img src="assets/img/products/4.jpg" alt="prod1">
                <div class="sigma_cart-product-body">
                  <h6>Mahabharat Book</h6>
                  <div class="sigma_product-price justify-content-start">
                    <span>50$</span>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        <li class="sigma_header-wishlist style-2">
          <a href="wishlist.html"> <i class="fal fa-heart"></i> </a>
          <ul class="cart-dropdown">
            <li>
              <p class="mb-0">You don't have any items</p>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>