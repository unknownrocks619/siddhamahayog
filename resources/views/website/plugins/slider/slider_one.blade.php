
  <!-- Banner Start -->
  <div class="sigma_banner banner-2">

    <div class="sigma_banner-slider">
    @foreach (plugins_slider() as  $slider)
      <!-- Banner Item Start -->
      <div class="light-bg sigma_banner-slider-inner bg-cover bg-center dark-overlay dark-overlay-2 bg-norepeat" style="background-image: url('{{ $slider->slider_file }}');">
        <div class="sigma_banner-text">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-6 text-center">
                <span class="highlight-text">We Believe in Rama</span>
                <h1 class="text-white title">Temple Of Rama</h1>
                <p class="mb-0"> We are a Hindu that belives in Lord Rama and Vishnu Deva the followers and We are a Hindu</p>
                <a href="about-us.html" class="sigma_btn-custom section-button">Explore Temple <i class="far fa-arrow-right"></i> </a>
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