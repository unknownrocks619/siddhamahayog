@extends("frontend.theme.master")

@section("page_title")
:: Sadhana
@endsection

@section("page_css")
<style>
    .subscription.bg-white {
        background: none;
    }

    .bg-white {
        background-color: #fff !important;
    }

    .subscription.bg-white .subscription-wrapper {
        background: #fff;
    }

    .subscription-wrapper {
        border-radius: 0% 5% 10% 3%/10% 20% 0% 17%;
        -webkit-transform: perspective(1800px) rotateY(20deg) skewY(1deg) translateX(50px);
        transform: perspective(1800px) rotateY(20deg) skewY(1deg) translateX(50px);
        padding: 70px 50px;
        z-index: 1;
        width: 100%;
        background: linear-gradient(80deg, #0030cc 0%, #00a4db 100%);
        /* position: absolute; */
        top: 100px;
        margin-top: 100px
    }

    .subscription-wrapper {
        box-shadow: 0px 15px 39px 0px rgba(8, 18, 109, 0.1) !important;
    }

    .subscription-content {
        -webkit-transform: skewY(-1deg);
        transform: skewY(-1deg);
    }

    h3,
    .h3 {
        font-size: 30px;
    }

    .flex-fill {
        -ms-flex: 1 1 auto !important;
        flex: 1 1 auto !important;
    }

    .subscription.bg-white .form-control {
        border: 1px solid #ebebeb !important;
    }

    .subscription-wrapper .form-control {
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 45px;
    }

    .subscription-wrapper .form-control:focus {
        background: rgba(255, 255, 255, 0.1);
        outline: 0;
        box-shadow: none;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .btn-primary {
        border: 0;
        color: #fff;
    }



    .btn {
        font-size: 16px;
        font-family: "Poppins", sans-serif;
        text-transform: capitalize;
        padding: 18px 45px;
        border-radius: 45px;
        font-weight: 500;
        border: 1px solid;
        position: relative;
        z-index: 1;
        transition: .3s ease-in;
        overflow: hidden;
    }

    .btn-primary:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 102%;
        height: 100%;
        background: linear-gradient(45deg, #00a8f4 0%, #02d1a1 100%);
        z-index: -1;
        transition: ease 0.3s;
    }

    .pricing-card {
        flex-direction: column;
        min-width: 0;
        color: #000;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #fff;
        border-radius: 6px;
        -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250);
        -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1);
        box-shadow: 0px 0px 5px 0px rgb(161, 163, 164);
    }

    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary:visited,
    .btn-primary:focus {
        background-color: #314666 !important;
        border-color: #314666 !important;
    }
</style>
@endsection

@section("content")
<!-- partial:partia/__subheader.html -->
<div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ asset('themes/om/assets/img/events/sadhana/sadhana-banner.jpg') }})">

    <div class="container">
        <div class="sigma_subheader-inner" style="align-items: flex-start">
            <div class="sigma_subheader-text">
                <h1 style="color:#db4242">Mahayog Sadhana</h1>
            </div>
        </div>
    </div>

</div>

<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <div class="container">
        <div class="row sigma_broadcast-video">
            <div class="col-12 mb-5">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="sigma_video-popup-wrap">
                            <img src="assets/img/video-gallery/01.png" alt="video">
                            <a href="https://www.youtube.com/watch?v=TKnufs85hXk" class="sigma_video-popup popup-youtube">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="sigma_box m-0">
                            <h4 class="title">Sadhana, Journey to Spritual path</h4>
                            <p class="m-0">
                                The quick brown fox jumps over a lazy dog.The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.

                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.
                                The quick brown fox jumps over a lazy dog.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ asset ('themes/om/assets/img/puja/details/4.jpg') }}" class="gallery-thumb">
                    <img src="{{ asset ('themes/om/assets/img/puja/details/4.jpg') }}" alt="post">
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ asset ('assets/images/sadhana/sadhana-small-two.jpg') }}" class="gallery-thumb">
                    <img src="{{ asset ('assets/images/sadhana/sadhana-small-two.jpg') }}" alt="post">
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ asset ('assets/images/sadhana/sadhana-small-three.jpg') }}" class="gallery-thumb">
                    <img src="{{ asset ('assets/images/sadhana/sadhana-small-three.jpg') }}" alt="post">
                </a>
            </div>
        </div>
    </div>
</div>

<section class="subscription bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="subscription-wrapper">
                    <div class="d-flex subscription-content justify-content-between align-items-center flex-column flex-md-row text-center text-md-left">
                        <h3 class="flex-fill">Subscribe <br> to our newsletter</h3>
                        <div class="col-lg-5 my-md-2 my-2">
                            <a href="{{ route('sadhana.create') }}" type="submit" class="btn btn-primary btn-lg border-0 w-100">Subscribe Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<blockquote>
    <cite>By Gurudev </cite>
    <p>Some Hindu teachers insist that believing in rebirth is necessary for living an ethical life. Their concern is that if there is no fear of karmic repercussions in future lifetimes</p>
</blockquote>


<!-- 

FAQ
-->
<section class="section">
    <div class="container">

        <div class="row align-items-center">
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset ('assets/images/sadhana/sadhana-faq-image.jpg') }}" class="w-100" alt="about">
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

<!--
    subscriben
-->
<div class="container mt-5" style="background:#64748B">
    <div class="row">
        <div class="col-md-6">
            <div class="pricing-card p-3 text-center py-5 mt-2">
                <div class="images">
                    <img src="https://i.imgur.com/YSHRu45.png" width="50">
                </div>
                <h6 class="mt-3">
                    Starter
                </h6>
                <span class="d-block font-weight-bold mt-3">$5</span>
                <span class="d-block">PER MONTH</span>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="subscribtion" value="yearly" />
                    <button class="btn btn-primary shadow mt-4 px-5 rounded-pill" type="submit">Subscribe Now</button>
                </form>
                <div class="mt-3"><span class="d-block"><i class="fa fa-check"></i>&nbsp;Access to all content</span><span class="text-left"><i class="fa fa-check"></i>&nbsp;Access to stack Work</span></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pricing-card p-3 text-center py-5 mt-2">
                <div class="images"><img src="https://i.imgur.com/YSHRu45.png" width="50"><img src="https://i.imgur.com/YSHRu45.png" width="50"></div>
                <h6 class="mt-3">
                    Yearly
                </h6>
                <span class="d-block font-weight-bold mt-3">$2</span>
                <span class="d-block">PER MONTH</span>
                <form action="{{ route('sadhana.sadhana_payment_process') }}" method="post">
                    @csrf
                    <button class="btn btn-primary shadow mt-4 px-5 rounded-pill" type="submit">
                        Subscribe Now
                    </button>
                </form>
                <div class="mt-3">
                    <span class="d-block">
                        <i class="fa fa-check"></i>&nbsp;Access to all content</span><span class="text-left">
                        <i class="fa fa-check"></i>&nbsp;Access to stack Work</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section("page_script")
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    const myCarousel = new Carousel(document.querySelector(".carousel"), {
        // Options
    });
</script>
@endsection