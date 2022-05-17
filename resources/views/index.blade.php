@extends("layouts.app")

@section("content")

    @include("website.plugins.slider.slider")

  <!-- Holis Start -->
  <div class="section section-padding tirtery-bg">
    <div class="container">
      <div class="row sigma_sermon-box-wrapper">
        <div class="col-lg-6">
          <div class="sigma_sermon-box">
            <div class="sigma_box">
              <span class="subtitle">Next Event</span>
              <h4 class="title mb-0">
                <a href="event-details.html">Which is the same as saying</a>
              </h4>
              <div class="sigma_sermon-info">
                <div class="sigma_sermon-date">
                  <span>20</span>
                  Aug'21
                </div>
                <ul class="sigma_sermon-descr m-0">
                  <li>
                    <i class="far fa-clock"></i>
                    Sunday 8:00 - 9:00 am
                  </li>
                  <li>
                    <i class="far fa-map-marker-alt"></i>
                    56 Thatcher Avenue River Forest Chicago, IL United <br>States
                  </li>
                </ul>
              </div>
              <div class="section-button d-flex align-items-center">
                <a href="event-details.html" class="sigma_btn-custom secondary">Join Now <i class="far fa-arrow-right"></i> </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="sigma_sermon-box">
            <div class="sigma_box">
              <span class="subtitle">Latest Holis</span>
              <h4 class="title mb-0">
                <a href="holi-details.html">Holi- The Colour Festival</a>
              </h4>
              <ul class="sigma_sermon-info mb-0">
                <li>
                  <i class="far fa-user"></i>
                  Message From
                  <a href="#" class="ms-2"><u>Yeshvant Parsad</u></a>
                </li>
                <li  class="mt-0 ms-4">
                  <i class="far fa-calendar-check"></i>
                  Aug 12, 2022
                </li>
              </ul>
              <ul class="sigma_sm square">
                <li>
                  <a href="#">
                    <i class="fab fa-youtube"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="far fa-file-pdf"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fas fa-share-alt"></i>
                  </a>
                </li>
              </ul>
              <div class="sigma_audio-player">
                <div id="play-btn">
                  <i class="fa fa-play"> </i>
                  <i class="fa fa-pause"></i>
                </div>
                <div class="audio-wrapper" id="player-container">
                  <audio id="player" ontimeupdate="initProgressBar()">
                    <source src="assets/audio/1.wav" type="audio/mp3">
                    </audio>
                  </div>
                  <div class="player-controls scrubber">
                    <small class="end-time">5:44</small>
                    <span id="seekObjContainer"> <progress id="seekObj" value="0" max="1"></progress> </span>
                    <i class="fa fa-volume-up"></i>
                  </div>
                  <div class="next_prev">
                    <i class="fa fa-angle-left"></i>
                    <i class="fa fa-angle-right"></i>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Holis End -->

  <!-- Icons Start -->
  <div class="section section-padding">
    <div class="container">
      <div class="section-title section-title-2 text-center">
        <p class="subtitle">Features</p>
        <h4 class="title">How We Can Help</h4>
      </div>

      <div class="row">

        <div class="col-md-6">
          <div class="sigma_icon-block icon-block-2">
            <div class="icon-wrapper">
              <i class="flaticon-surya"></i>
            </div>
            <div class="sigma_icon-block-content">
              <h5> Spiritual Service </h5>
              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              <i class="far fa-arrow-right"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="sigma_icon-block icon-block-2">
            <div class="icon-wrapper">
              <i class="flaticon-hindu-2"></i>
            </div>
            <div class="sigma_icon-block-content">
              <h5>Relief Service</h5>
              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              <i class="far fa-arrow-right"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="sigma_icon-block icon-block-2">
            <div class="icon-wrapper">
              <i class="flaticon-hindu-wedding"></i>
            </div>
            <div class="sigma_icon-block-content">
              <h5> Medical Service </h5>
              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              <i class="far fa-arrow-right"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="sigma_icon-block icon-block-2">
            <div class="icon-wrapper">
              <i class="flaticon-bhogi"></i>
            </div>
            <div class="sigma_icon-block-content">
              <h5> Spiritual Service </h5>
              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              <i class="far fa-arrow-right"></i>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
  <!-- Icons End -->

  <!-- About Start -->
  <section class="section section-md light-bg">
    <div class="container">

      <div class="row align-items-center">
        <div class="col-lg-6 mb-lg-30">
          <div class="section-title section-title-2 text-start">
            <p class="subtitle">About Us</p>
            <h4 class="title">We are a Hindu that believe in Ram</h4>
            <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure</p>
          </div>
          <div class="d-flex align-items-center mt-5">
            <div class="sigma_round-button me-4 sm">
              <span> <b class="counter" data-to="75" data-from="0">0</b> <span class="custom-primary">%</span> </span>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                <circle data-to="290" class="sigma_progress-round sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
              </svg>
            </div>
            <div>
              <h5 class="mb-2">Hindu Community</h5>
              <p class="mb-0">If money help a man to do well to others, it is of some value; but if not, it is simply a mass of evil, and the sooner</p>
            </div>
          </div>
          <div class="d-flex align-items-center mt-5">
            <div class="sigma_round-button me-4 sm">
              <span> <b class="counter" data-to="50" data-from="0">0</b> <span class="custom-secondary">%</span> </span>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
                <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
                <circle data-to="400" class="sigma_progress-round sigma_round-button-circle secondary" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
              </svg>
            </div>
            <div>
              <h5 class="mb-2">Active Members</h5>
              <p class="mb-0">If money help a man to do well to others, it is of some value; but if not, it is simply a mass of evil, and the sooner</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <div class="me-lg-30 img-group-2">
            <img src="assets/img/about-group2/1.jpg" alt="about">
            <img src="assets/img/about-group2/2.jpg" alt="about">
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- About End -->

  <!-- CTA Start -->
  <div class="section mt-negative-md p-0 d-none d-lg-block">
    <div class="container">
      <div class="p-5 bg-cover d-block d-md-flex align-items-center justify-content-between" style="background-image: url(assets/img/textures/abstract2.png)">
        <div>
          <h5 class="text-white mb-2">Still You Need Our Support</h5>
          <p class="text-white mb-0"> Don't wait make a smart & Logical quote here. It's pretty easy. </p>
        </div>
        <a href="contact-us.html" class="mt-3 mt-md-0 sigma_btn-custom text-white light">Get a Quote</a>
      </div>
    </div>
  </div>
  <!-- CTA End -->

  <!-- Map Start -->
  <div class="section d-none d-lg-block p-0">
    <div class="container">
      <img src="assets/img/textures/map.png" alt="map">

      <div class="map-markers">

        <div class="map-marker marker-1">
          <span></span>
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

        <div class="map-marker marker-2">
          <span></span>
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

        <div class="map-marker marker-3">
          <span></span>
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

        <div class="map-marker marker-4 right">
          <span></span>
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

        <div class="map-marker marker-5 right">
          <img src="assets/img/people/1.jpg" alt="person">
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

        <div class="map-marker marker-6 right">
          <img src="assets/img/people/2.jpg" alt="person">
          <div class="map-marker-content">
            <p>Puja is the worship of the Lord, Donation is a good act consectet ur adipisicing elit, sed do eiusmod</p>
            <span> <b class="text-white">Rakesh K Patel</b> / <b class="custom-primary">Pandit</b> </span>
          </div>
        </div>

      </div>

    </div>
  </div>
  <!-- Map End -->

  <!-- Portfolio Start -->
  <div class="section section-padding bg-cover portfolio-section" style="background-image: url(assets/img/textures/abstract.png)">
    <div class="container">

      <div class="section-title section-title-2 flex-title">
        <div>
          <p class="subtitle light">Portfolio</p>
          <h4 class="text-white title mb-lg-0">Our Puja</h4>
        </div>
        <div class="sigma_arrows">
          <i class="far fa-chevron-left slick-arrow slider-prev"></i>
          <i class="far fa-chevron-right slick-arrow slider-next"></i>
        </div>
      </div>

      <div class="portfolio-slider">

        <div class="sigma_portfolio-item style-3">
          <img src="assets/img/puja/style-3/1.jpg" alt="portfolio">
          <div class="sigma_portfolio-item-content">
            <div class="sigma_portfolio-item-content-inner">
              <a href="#">Temple</a>
              <h5> <a href="puja-details.html">Diwali </a> </h5>
            </div>
            <a href="puja-details.html"><i class="far fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="sigma_portfolio-item style-3">
          <img src="assets/img/puja/style-3/2.jpg" alt="portfolio">
          <div class="sigma_portfolio-item-content">
            <div class="sigma_portfolio-item-content-inner">
              <a href="#">Temple</a>
              <h5> <a href="puja-details.html"> Dusseshra </a> </h5>
            </div>
            <a href="puja-details.html"><i class="far fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="sigma_portfolio-item style-3">
          <img src="assets/img/puja/style-3/3.jpg" alt="portfolio">
          <div class="sigma_portfolio-item-content">
            <div class="sigma_portfolio-item-content-inner">
              <a href="#">Temple</a>
              <h5> <a href="puja-details.html"> Holis </a> </h5>
            </div>
            <a href="puja-details.html"><i class="far fa-arrow-right"></i></a>
          </div>
        </div>

      </div>

    </div>
  </div>
  <!-- Portfolio End -->

  <!-- FAQ Start -->
  <section class="section">
    <div class="container">

      <div class="row align-items-center">
        <div class="col-lg-6 d-none d-lg-block">
          <img src="assets/img/about3.jpg" class="w-100" alt="about">
        </div>
        <div class="col-lg-6">
          <div class="me-lg-30">
            <div class="section-title section-title-2 text-start">
              <p class="subtitle">FAQ</p>
              <h4 class="title">Get Every Answer From Over Here</h4>
              <p> People ask questions related to Hinduism time without restricting creative freedom </p>
            </div>
            <div class="accordion with-gap" id="generalFAQExample">
              <div class="card">
                <div class="card-header" data-bs-toggle="collapse" role="button" data-bs-target="#generalOne" aria-expanded="true" aria-controls="generalOne">
                  What is a Temple?
                </div>

                <div id="generalOne" class="collapse show" data-bs-parent="#generalFAQExample">
                  <div class="card-body">
                    Temple is a place where Hindu worship our Bhagwan Ram, Shiva, Vishnu, Krishna etc. Proin eget tortor risus. Vivamus magna justo, .People ask questions related to Hinduism
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" data-bs-toggle="collapse" role="button" data-bs-target="#generalTwo" aria-expanded="false" aria-controls="generalTwo">
                  Getting Started with an Temple
                </div>

                <div id="generalTwo" class="collapse" data-bs-parent="#generalFAQExample">
                  <div class="card-body">
                    Temple is a place where Hindu worship our Bhagwan Ram, Shiva, Vishnu, Krishna etc. Proin eget tortor risus. Vivamus magna justo, .People ask questions related to Hinduism
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" data-bs-toggle="collapse" role="button" data-bs-target="#generalThree" aria-expanded="false" aria-controls="generalThree">
                  Do i have the latest version?
                </div>

                <div id="generalThree" class="collapse" data-bs-parent="#generalFAQExample">
                  <div class="card-body">
                    Temple is a place where Hindu worship our Bhagwan Ram, Shiva, Vishnu, Krishna etc. Proin eget tortor risus. Vivamus magna justo, .People ask questions related to Hinduism
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- FAQ End -->

   <!-- Video Start -->
  <div class="section section-lg bg-cover bg-norepeat bg-center" style="background-image: url(assets/img/bg1.jpg)">
    <div class="section d-flex align-items-center justify-content-center">
      <a href="https://www.youtube.com/watch?v=TKnufs85hXk" class="sigma_video-popup popup-youtube">
        <i class="fas fa-play"></i>
      </a>
    </div>
  </div>
  <!-- Video End -->

  <!-- Portfolio Start -->
  <div class="section section-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 coaching">
          <div class="sigma_portfolio-item">
            <img src="assets/img/puja/lg/1.jpg" alt="portfolio">
            <div class="sigma_portfolio-item-content">
              <div class="sigma_portfolio-item-content-inner">
                <h5> <a href="puja-details.html"> Spiritual Service </a> </h5>
                <p>Puja is the worship of the Lord, consectet ur adipisicing elit, sed do eiusmod</p>
              </div>
              <a href="puja-details.html"><i class="fal fa-plus"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 strategy">
          <div class="sigma_portfolio-item">
            <img src="assets/img/puja/lg/2.jpg" alt="portfolio">
            <div class="sigma_portfolio-item-content">
              <div class="sigma_portfolio-item-content-inner">
                <h5> <a href="puja-details.html"> Temple Wedding </a> </h5>
                <p>Puja is the worship of the Lord, consectet ur adipisicing elit, sed do eiusmod</p>
              </div>
              <a href="puja-details.html"><i class="fal fa-plus"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 coaching strategy">
          <div class="sigma_portfolio-item">
            <img src="assets/img/puja/lg/3.jpg" alt="portfolio">
            <div class="sigma_portfolio-item-content">
              <div class="sigma_portfolio-item-content-inner">
                <h5> <a href="puja-details.html"> Relief Service </a> </h5>
                <p>Puja is the worship of the Lord, consectet ur adipisicing elit, sed do eiusmod</p>
              </div>
              <a href="puja-details.html"><i class="fal fa-plus"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Portfolio End -->

  <!-- Blog Start -->
  <div class="section section-padding pt-0">
    <div class="container">

      <div class="section-title section-title-2 text-center">
        <p class="subtitle">Blog</p>
        <h4 class="title">Temple News Feed</h4>
      </div>

      <div class="row">

        <!-- Article Start -->
        <div class="col-lg-4 col-md-6">
          <article class="sigma_post style-2">
            <div class="sigma_post-thumb">
              <a href="blog-details.html">
                <img src="assets/img/blog/2.jpg" alt="post">
              </a>
            </div>
            <div class="sigma_post-body">
              <div class="sigma_post-meta">
                <a href="blog-details.html" class="sigma_post-date"> <i class="far fa-calendar"></i> May 20, 2022</a>
              </div>
              <h5> <a href="blog-details.html">Education for all rural children are necessary.</a> </h5>
            </div>
          </article>
        </div>
        <!-- Article End -->

        <!-- Article Start -->
        <div class="col-lg-4 col-md-6">
          <article class="sigma_post style-2">
            <div class="sigma_post-thumb">
              <a href="blog-details.html">
                <img src="assets/img/blog/1.jpg" alt="post">
              </a>
            </div>
            <div class="sigma_post-body">
              <div class="sigma_post-meta">
                <a href="blog-details.html" class="sigma_post-date"> <i class="far fa-calendar"></i> May 20, 2022</a>
              </div>
              <h5> <a href="blog-details.html">Temple companies are being so transparent.</a> </h5>
            </div>
          </article>
        </div>
        <!-- Article End -->

        <!-- Article Start -->
        <div class="col-lg-4 col-md-6">
          <article class="sigma_post style-2">
            <div class="sigma_post-thumb">
              <a href="blog-details.html">
                <img src="assets/img/blog/3.jpg" alt="post">
              </a>
            </div>
            <div class="sigma_post-body">
              <div class="sigma_post-meta">
                <a href="blog-details.html" class="sigma_post-date"> <i class="far fa-calendar"></i> May 20, 2022</a>
              </div>
              <h5> <a href="blog-details.html">How to abide by Puja rules without any risks.</a> </h5>
            </div>
          </article>
        </div>
        <!-- Article End -->

      </div>

    </div>

  </div>
  <!-- Blog End -->

  <!-- Icons Start -->
  <div class="section mb-negative p-0">
    <div class="container">
      <div class="sigma_box pb-0 m-0">
        <div class="row">

          <div class="col-md-4">
            <div class="sigma_icon-block icon-block-3">
              <div class="icon-wrapper">
                <i class="flaticon-temple"></i>
              </div>
              <div class="sigma_icon-block-content">
                <h5> Temple </h5>
                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="sigma_icon-block icon-block-3">
              <div class="icon-wrapper">
                <i class="flaticon-hindu-1"></i>
              </div>
              <div class="sigma_icon-block-content">
                <h5> Pandit </h5>
                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="sigma_icon-block icon-block-3">
              <div class="icon-wrapper">
                <i class="flaticon-arti"></i>
              </div>
              <div class="sigma_icon-block-content">
                <h5> Puja </h5>
                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Icons End -->

@endsection