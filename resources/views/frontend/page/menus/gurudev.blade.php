@extends("frontend.theme.master")
@section("content")
<x-banner style="background-image: url({{ asset('assets/images/menu/banners/jagadguru-banner.jpg') }})">
</x-banner>


<!-- About Start -->
<section class="section">
    <div class="container">

        <div class="row align-items-center">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="sigma_img-box">
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="https://unknownrocks619.github.io/s_draft/assets/img/siddhamahayog/guru/Sakipaath.jpeg" alt="service">
                            <img class="ms-0" src="https://unknownrocks619.github.io/s_draft/assets/img/siddhamahayog/banner/banner-four.jpg" alt="service">
                        </div>
                        <div class="col-lg-6 mt-0 mt-lg-5">
                            <img src="https://unknownrocks619.github.io/s_draft/assets/img/siddhamahayog/gurudev/gurudev-one-cropped.jpg" alt="service">
                            <img class="ms-0" src="{{ asset('assets/images/menu/gurudev-white.jpg') }}" alt="service">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="me-lg-30">
                    <div class="section-title mb-0 text-start">
                        <p class="subtitle">Jagadguru Mahayogi Siddha Baba</p>
                        <h4 class="title">Samadhi Siddha Guru</h4>
                    </div>
                    <p class="blockquote bg-transparent">Jagatguru Shree Vaishnava Krishnadas Ji Maharaj is popularly known as Mahayogi Siddha Baba. He uniquely possesses three rare qualities, that is exceptional to find all in one individual. </p>
                    <div class="sigma_icon-block icon-block-3">
                        <div class="icon-wrapper">
                            <img src="assets/img/textures/icons/1.png" alt="">
                        </div>
                        <div class="sigma_icon-block-content">
                            <h5> Samadhi-siddha </h5>
                            <p>, achieving a state of spiritual perfection that is beyond time and space.</p>
                        </div>
                    </div>
                    <div class="sigma_icon-block icon-block-3">
                        <div class="icon-wrapper">
                            <img src="assets/img/textures/icons/2.png" alt="">
                        </div>
                        <div class="sigma_icon-block-content">
                            <h5> Jagatguru </h5>
                            <p>Decorated with the highest spiritual honor <em>Jagatguru</em> (Guru of the Universe).</p>
                        </div>
                    </div>
                    <div class="sigma_icon-block icon-block-3">
                        <div class="icon-wrapper">
                            <img src="assets/img/textures/icons/2.png" alt="">
                        </div>
                        <div class="sigma_icon-block-content">
                            <h5> Shaktipat Deeksha </h5>
                            <p>Master of Shaktipat Deeksha, able to transmit his divine conscious energy to meditators in order to awaken their Kundalini energy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- About End -->


<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <div class="container">
        <div class="row sigma_broadcast-video">
            <div class="col-12 mb-5">
                <div class="section-title mb-0 text-start">
                    <p class="subtitle">Guruparam para</p>
                    <h4 class="title">Lineages</h4>
                </div>
                <img src="{{ asset('assets/images/menu/guru-parampara-template.jpg') }}" class="img-fluid w-100" />
            </div>
        </div>
    </div>
</div>



@endsection