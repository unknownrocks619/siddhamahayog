 <!-- Banner Start -->
 <div class="sigma_banner banner-1 bg-cover light-overlay bg-center bg-norepeat" style="background-image: url(assets/img/banner/9.jpg)">

<div class="sigma_banner-slider">
 @foreach (plugins_slider() as $slider)
  <!-- Banner Item Start -->
  <div class="sigma_banner-slider-inner">
    <div class="sigma_banner-text">
      <div class="container position-relative">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="sigma_box primary-bg banner-cta">
              <h1 class="text-white title">Mere Ganpati Guru Ganesh Ji Tusi Aa Jao.</h1>
              <p class="blockquote light light-border mb-0"> We are a Hindu that belives in Lord Rama and Vishnu Deva the followers and We are a Hindu that belives in Lord Rama and Vishnu Deva.</p>
              <div class="section-button d-flex align-items-center">
                <a href="contact-us.html" class="sigma_btn-custom secondary">Join Today <i class="far fa-arrow-right"></i> </a>
                <a href="donation.html" class="ms-3 sigma_btn-custom light text-white">Donate Us <i class="far fa-arrow-right"></i> </a>
              </div>
            </div>
          </div>
        </div>
        <img class="d-none d-lg-block" src="{{ $slider->slider_file }}" alt="png">
      </div>
    </div>
  </div>
  <!-- Banner Item End -->
 @endforeach
</div>

</div>
<!-- Banner End -->