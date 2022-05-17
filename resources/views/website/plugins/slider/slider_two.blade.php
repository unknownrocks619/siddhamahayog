
  <!-- Banner Start -->
  <div class="sigma_banner banner-3">

    <div class="sigma_banner-slider">
    @foreach (plugins_slider() as $slider)
      <!-- Banner Item Start -->
      <div class="light-bg sigma_banner-slider-inner bg-cover bg-center bg-norepeat" style="background-image: url('{{ $slider->slider_file }}');">
        <div class="sigma_banner-text">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h1 class="title">Some Important Life Lessons From Gita</h1>
                <p class="blockquote mb-0 bg-transparent"> We are a Hindu that belives in Lord Rama and Vishnu Deva the followers and We are a Hindu that belives in Lord Rama and Vishnu Deva. This is where you should start </p>
                <div class="section-button d-flex align-items-center">
                  <a href="contact-us.html" class="sigma_btn-custom">Join Today <i class="far fa-arrow-right"></i> </a>
                  <a href="services.html" class="ms-3 sigma_btn-custom white">View Services <i class="far fa-arrow-right"></i> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Banner Item End -->
    @endforeach

    </div>

  </div>
  <!-- Banner End -->