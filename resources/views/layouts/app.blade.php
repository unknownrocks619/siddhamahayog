<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Siddhamayog.org') }}</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ site_settings('favicon') }}">

  <!-- partial:partial/__stylesheets.html -->
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/slick.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/slick-theme.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/ion.rangeSlider.min.css') }}">

  <!-- Icon Fonts -->
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/fonts/flaticon/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/plugins/font-awesome.min.css') }}">
  <!-- Template Style sheet -->
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset ('themes/om/assets/css/responsive.css') }}">
  <!-- partial -->

</head>

<body>

    @if(site_settings("loading_bar") )
        <!-- Preloader Start -->
        <div class="sigma_preloader">
            <img src="{{ site_settings('loading_bar_image') }}" alt="preloader">
        </div>
        <!-- Preloader End -->
    @endif
  <!-- partial:partial/__quickview.html -->
  <div class="modal fade sigma_quick-view-modal" id="quickViewModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">

          <div class="close-btn close-dark close" data-bs-dismiss="modal">
            <span></span>
            <span></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="sigma_product-single-thumb">
                <img src="assets/img/products/new/1.jpg" alt="product">
              </div>
            </div>
            <div class="col-md-6">

              <div class="sigma_product-single-content">

                <h4 class="entry-title"> Koobay 14" Wooden Trousers Bottom Clips Hangers w Rose Gold. </h4>

                <div class="sigma_product-price">
                  <span>352$</span>
                  <span>245$</span>
                </div>

                <div class="sigma_rating-wrapper">
                  <div class="sigma_rating">
                    <i class="far fa-star active"></i>
                    <i class="far fa-star active"></i>
                    <i class="far fa-star active"></i>
                    <i class="far fa-star active"></i>
                    <i class="far fa-star"></i>
                  </div>
                  <span>255 Reviews</span>
                </div>

                <p> <strong class="me-2">Interested: <span>05</span></strong> <strong>Availablity: <span>In Stock</span></strong> </p>

                <p class="sigma_product-excerpt">All Religious Books are available in Temple Stores. Our mission is to share the Good of Hinduism, Loving, Faith and Serving.</p>

                <form class="sigma_product-atc-form">

                  <div class="sigma_product-variation-wrapper">
                    <div class="sigma_product-radio form-group">
                      <label>
                        <input type="radio" name="size" value="" checked>
                        <span>XS</span>
                      </label>
                      <label>
                        <input type="radio" name="size" value="">
                        <span>S</span>
                      </label>
                      <label>
                        <input type="radio" name="size" value="">
                        <span>M</span>
                      </label>
                      <label>
                        <input type="radio" name="size" value="">
                        <span>L</span>
                      </label>
                      <label>
                        <input type="radio" name="size" value="">
                        <span>XL</span>
                      </label>
                    </div>
                  </div>

                  <div class="qty-outter">
                    <a href="product-single.html" class="sigma_btn-custom secondary">Buy Now</a>
                    <div class="qty-inner">
                      <h6>Qty:</h6>
                      <div class="qty">
                        <span class="qty-subtract"><i class="fa fa-minus"></i></span>
                        <input type="text" name="qty" value="1">
                        <span class="qty-add"><i class="fa fa-plus"></i></span>
                      </div>
                    </div>
                  </div>

                </form>

                <!-- Post Meta Start -->
                <div class="sigma_post-single-meta">
                  <div class="sigma_post-single-meta-item sigma_post-share">
                    <h6>Share</h6>
                    <ul class="sigma_sm">
                      <li>
                        <a href="#">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fab fa-youtube"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="sigma_post-single-meta-item">
                    <div class="sigma_product-controls">
                      <a href="#" data-toggle="tooltip" title="Compare"> <i class="far fa-signal-4"></i> </a>
                      <a href="#" data-toggle="tooltip" title="Wishlist"> <i class="far fa-heart"></i> </a>
                    </div>
                  </div>
                </div>
                <!-- Post Meta End -->

              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- partial -->


  <!-- partial:partia/__sidenav.html -->
  <aside class="sigma_aside sigma_aside-right sigma_aside-right-panel sigma_aside-bg">
    <div class="sidebar">

      <div class="sidebar-widget widget-logo">
        <img src="{{ site_settings('logo') }}" class="mb-30" alt="{{ site_settings('website_name') }}">
        <p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Donec rutrum congue leo eget malesuada. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</p>
      </div>

      <!-- Instagram Start -->
      <div class="sidebar-widget widget-ig">
        <h5 class="widget-title">Instagram</h5>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/1.jpg" alt="ig">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/2.jpg" alt="ig">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/3.jpg" alt="ig">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/4.jpg" alt="ig">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/5.jpg" alt="ig">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-6">
            <a href="#" class="sigma_ig-item">
              <img src="assets/img/ig/6.jpg" alt="ig">
            </a>
          </div>
        </div>
      </div>
      <!-- Instagram End -->

      <!-- Social Media Start -->
      <div class="sidebar-widget">
        <h5 class="widget-title">Follow Us</h5>
        <div class="sigma_post-share">
          <ul class="sigma_sm">
            <li>
              <a href="#" class="sigma_round-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="125px" height="125px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                  <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                  <circle class="sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                </svg>
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="#" class="sigma_round-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="125px" height="125px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                  <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                  <circle class="sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                </svg>
                <i class="fab fa-linkedin-in"></i>
              </a>
            </li>
            <li>
              <a href="#" class="sigma_round-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="125px" height="125px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                  <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                  <circle class="sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                </svg>
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li>
              <a href="#" class="sigma_round-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="125px" height="125px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                  <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                  <circle class="sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                </svg>
                <i class="fab fa-youtube"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Social Media End -->

    </div>
  </aside>
  <div class="sigma_aside-overlay aside-trigger-right"></div>
  <!-- partial -->

  <!-- partial:partia/__mobile-nav.html -->
  <aside class="sigma_aside sigma_aside-left">

    <a class="navbar-brand" href="index.html">
        <img src="{{ site_settings('logo') }}" alt="logo"> </a>

    <!-- Menu -->
    <ul>
      @foreach (menus() as $menu)
        @if($menu->menu_position == "main_menu" && ! $menu->parent_menu )
          <li class="menu-item @if(menus()->where('parent_menu',$menu->id)->count()) menu-item-has-children @endif">
            <a href="">
              {{ $menu->menu_name }}
            </a>
            @if(menus()->where('parent_menu',$menu->id)->count())
              <ul class="sub-menu">
                @foreach (menus()->where('parent_menu') as $child_menu)
                  <li class="menu-item">
                    <a href="">
                      {{ $child_menu->menu_name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endif

      @endforeach
    </ul>

  </aside>
  <div class="sigma_aside-overlay aside-trigger-left"></div>
  <!-- partial -->

  @include("inc.website.header")


  @yield("content")

  <!-- partial:partia/__footer.html -->
  <footer class="sigma_footer footer-2">

    <!-- Middle Footer -->
    <div class="sigma_footer-middle">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 footer-widget">
            <h5 class="widget-title">About Us</h5>
            <p class="mb-4">You need to be sure there isn’t anything embarrassing hidden in the middle of text. </p>
            <div class="d-flex align-items-center justify-content-md-start justify-content-center">
              <i class="far fa-phone custom-primary me-3"></i>
              <span>987-987-930-302</span>
            </div>
            <div class="d-flex align-items-center justify-content-md-start justify-content-center mt-2">
              <i class="far fa-envelope custom-primary me-3"></i>
              <span>info@example.com</span>
            </div>
            <div class="d-flex align-items-center justify-content-md-start justify-content-center mt-2">
              <i class="far fa-map-marker custom-primary me-3"></i>
              <span>14/A, Poor Street City Tower, New York USA</span>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 footer-widget">
            <h5 class="widget-title">Information</h5>
            <ul>
              <li> <a href="puja.html">Puja</a> </li>
              <li> <a href="services.html">Services</a> </li>
              <li> <a href="about-us.html">Temple</a> </li>
              <li> <a href="holi.html">Holis</a> </li>
              <li> <a href="volunteers.html">Volunteers</a> </li>
              <li> <a href="events.html">Donation</a> </li>
            </ul>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 footer-widget">
            <h5 class="widget-title">Others</h5>
            <ul>
              <li> <a href="shop.html">Shop</a> </li>
              <li> <a href="checkout.html">Checkout</a> </li>
              <li> <a href="donation-archive.html">Donation</a> </li>
              <li> <a href="contact-us.html">Contact Us</a> </li>
              <li> <a href="blog-grid.html">Blog</a> </li>
            </ul>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-3 col-sm-12 d-none d-lg-block footer-widget widget-recent-posts">
            <h5 class="widget-title">Recent Posts</h5>
            <article class="sigma_recent-post">
              <a href="blog-details.html"><img src="assets/img/blog/sm/1.jpg" alt="post"></a>
              <div class="sigma_recent-post-body">
                <a href="blog-details.html"> <i class="far fa-calendar"></i> May 20, 2022</a>
                <h6> <a href="blog-details.html">As we've all discovered by now, the world can change</a> </h6>
              </div>
            </article>
            <article class="sigma_recent-post">
              <a href="blog-details.html"><img src="assets/img/blog/sm/2.jpg" alt="post"></a>
              <div class="sigma_recent-post-body">
                <a href="blog-details.html"> <i class="far fa-calendar"></i> May 20, 2022</a>
                <h6> <a href="blog-details.html">Testimony love offering so blessed</a> </h6>
              </div>
            </article>
            <article class="sigma_recent-post">
              <a href="blog-details.html"><img src="assets/img/blog/sm/3.jpg" alt="post"></a>
              <div class="sigma_recent-post-body">
                <a href="blog-details.html"> <i class="far fa-calendar"></i> May 20, 2022</a>
                <h6> <a href="blog-details.html">As we've all discovered by now, the world can change</a> </h6>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="sigma_footer-bottom">
      <div class="container-fluid">
        <div class="sigma_footer-copyright">
          <p> Copyright © Maharatri - <a href="#" class="custom-primary">2022</a> </p>
        </div>
        <div class="sigma_footer-logo">
          <img src="{{ site_settings('logo') }}" alt="logo">
        </div>
        <ul class="sigma_sm square light">
          <li>
            <a href="#">
              <i class="fab fa-facebook-f"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fab fa-youtube"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>

  </footer>
  <!-- partial -->

  <!-- partial:partia/__scripts.html -->
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/imagesloaded.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.zoom.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.inview.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/jquery.event.move.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/wow.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/slick.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/ion.rangeSlider.min.js') }}"></script>
  <script src="{{ asset ('themes/om/assets/js/plugins/audio_custome.js') }}"></script>
  @if(site_settings('loading_bar') )
    <script type="text/javascript">

        /*-------------------------------------------------------------------------------
        Preloader
            -------------------------------------------------------------------------------*/
        $(window).on('load', function() {
            $('.sigma_preloader').addClass('hidden');
        });
    </script>
  @endif

  <script src="{{ asset ('themes/om/assets/js/main.js') }}"></script>
  <!-- partial -->

</body>

</html>
