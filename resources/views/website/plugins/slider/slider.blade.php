@php
// if ( ! \Illuminate\Support\Facades\Cache::has('slider_layout_settings') ) {
$slider_layout_settings = \App\Models\SliderSetting::where('active',true)->orderBy('id','DESC')->first();
\Illuminate\Support\Facades\Cache::put('slider_layout_settings',$slider_layout_settings);
// } else {
// $slider_layout_settings = \Illuminate\Support\Facades\Cache::get('slider_layout_ssettings');
// }
@endphp

@if($slider_layout_settings->layout == "default")
<!-- Banner Start -->
<div class="sigma_banner banner-2">

    <div class="sigma_banner-slider">
        @foreach (plugins_slider() as $slider)
        <!-- Banner Item Start -->
        <div class="light-bg sigma_banner-slider-inner bg-cover bg-center dark-overlay dark-overlay-2 bg-norepeat" style="background-image: url('{{ $slider->slider_file }}');">
            <div class="sigma_banner-text">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <span class="highlight-text">{{ $slider->tagline }}</span>
                            <h1 class="text-white title">{{ $slider->title }}</h1>
                            <div class="mb-0"> {!! $slider->description !!}</div>
                            <a href="{{ route('jagadguru') }}" class="sigma_btn-custom section-button">About Jagadguru <i class="far fa-arrow-right"></i> </a>
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
@elseif($slider_layout_settings->layout == "donation")
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
@else
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
@endif