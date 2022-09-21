@extends("frontend.theme.master")

@section("page_title")
Spiritual Academy
@endsection

@section("page_css")
<style>
  .custom-shape-divider-top-1654186157 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
  }

  .custom-shape-divider-top-1654186157 svg {
    position: relative;
    display: block;
    width: calc(109% + 1.3px);
    height: 150px;
  }

  .custom-shape-divider-top-1654186157 .shape-fill {
    fill: #EF7044 !important;
  }
</style>
@endsection



@section("content")

@include("website.plugins.slider.slider")

@include("frontend.page.event.home.shortcode")




@if(\App\Models\Program::where('program_type','sadhana')->exists() )

<div class="section section-padding pb-0" style="padding: 50px 0 50px">
  <div class="container m-0 p-0 mx-auto">
    <div class="row pt-0">
      <div class="col-md-12">
      </div>
    </div>
    <a href="{{ route('sadhana.detail') }}">
      <img src="{{ asset('assets/img/siddhamahayog/programs/vedanta-darshan-banner-one.jpeg') }}" class="img-fluid w-100" style="height: 225px !important" />
    </a>
  </div>
</div>
@endif


@include("index.about-gurudev")


<!-- Icons Start -->
<div class="section section-padding pt-1">
  <div class="container">
    <div class="section-title section-title-2 text-center">
      <p class="subtitle">Benefits</p>
      <h4 class="title">Help yourself, Heal yourself</h4>
    </div>

    <div class="row">

      <div class="col-md-6">
        <div class="sigma_icon-block icon-block-2">
          <div class="icon-wrapper">
            <i class="flaticon-surya"></i>
          </div>
          <div class="sigma_icon-block-content">
            <h5> Guidance from Mahayogi Siddha Baba </h5>
            <p>In any meditative path, guidance from a fully enlightened spiritual Guru (teacher) based on Guru-disciple tradition is essential for an aspiring meditator's progress. Mahayogi Siddha Baba brings mental, physical and spiritual well-being to his students and consistently guides them on their journey for peace, happiness, and ultimately self-realization. </p>
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
            <h5>Immediate awakening of your Kundalini</h5>
            <p>By the grace of Mahayogi Siddhababa one’s dormant Serpent Power (Kundalini) becomes immediately active through Shaktipaat Deeksha (transmission of spiritual power to an aspiring meditator). After awakening the Kundalini, aspirants can plug into their conscious energy source. Only upon awakening the Kundalini can one ultimately attain Supreme Consciousness.</p>
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
            <h5> Kriyas manifest based on your individual need </h5>
            <p>Once one begins this meditation, one's own Serpent power (Kundalini Shakti) decides what type of experiences to manifest in one's body based on the person's mental, physical and spiritual needs (e.g., automatic physical movements of all the four Yogas, namely Hatha yoga, Raja yoga, Mantra yoga, Laya yoga). No two experiences are alike, for meditation is tailored for the specific needs of the individual. What's more, all experiences automatically come about, it requires no strenuous or manual effort. </p>
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
            <h5> The fast path to full consciousness </h5>
            <p>In Himalayan Mahayoga, as one continues meditation the layers enveloping consciousness, which appear due to our actions (karma) and sanskara (mental and psychological imprints and impressions), slowly fade away. In this way, one gains the ability to become aware, to experience and feel unlike before, and to sense and be one with their soul. </p>
            <i class="far fa-arrow-right"></i>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<section class="section section-md light-bg">
  <div class="container">

    <div class="row align-items-center">
      <div class="col-lg-6 mb-lg-30">
        <div class="section-title section-title-2 text-start">
          <!-- <p class="subtitle">About Us</p> -->
          <h4 class="title">Vedanta Philosophy : Arthapanchak (Tatva-Gyan)</h4>
          <p>
            This 350-hour course is designed to fundamentally re-centre and vitalize true spiritual seekers. Whether or not you are new to the path of Himalayan Siddha Mahayog, you will have an exceptional opportunity to develop a foundational understanding of Vedanta and essence of devotion relevant to all walks of life, nations, spiritual traditions, and ethnicities. Learners on the divine quest will further be inspired by the direct teachings of </p>
        </div>
        <div class="d-flex align-items-center mt-5">
          <div class="sigma_round-button me-4 sm">
            <span> <b class="counter" data-to="95" data-from="0">0</b> <span class="custom-primary">%</span> </span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
              <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
              <circle data-to="290" class="sigma_progress-round sigma_round-button-circle" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
            </svg>
          </div>
          <div>
            <h5 class="mb-2">Stress Refelif</h5>
            <!-- <p class="mb-0"></p> -->
          </div>
        </div>
        <div class="d-flex align-items-center mt-5">
          <div class="sigma_round-button me-4 sm">
            <span> <b class="counter" data-to="90" data-from="0">0</b> <span class="custom-secondary">%</span> </span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 197 197" enable-background="new 0 0 197 197" xml:space="preserve">
              <circle class="sigma_round-button-stroke" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
              <circle data-to="400" class="sigma_progress-round sigma_round-button-circle secondary" stroke-linecap="round" cx="98.5" cy="98.6" r="97.5"></circle>
            </svg>
          </div>
          <div>
            <h5 class="mb-2">Mental Health</h5>
            <!-- <p class="mb-0">If money help a man to do well to others, it is of some value; but if not, it is simply a mass of evil, and the sooner</p> -->
          </div>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block">
        <div class="me-lg-30 img-group-2">
          <img src="{{ asset('assets/images/program/vedanta/image-one-bg.png') }}" alt="about">
        </div>
      </div>
    </div>

  </div>
</section>
<!-- About End -->

<!-- Icons End -->
<div class="section pt-0 pb-0">
  <div class="container-fluid m-0 p-0">
    <div class="row pt-0">
      <div class="col-md-12">
      </div>
    </div>
    <a href="{{ route('vedanta.index') }}"><img class="img-fluid" src="{{ asset('themes/om/assets/img/events/sadhana/banner-two.jpg') }}" /></a>

  </div>
</div>
<!-- About Start -->


<!-- FAQ Start -->
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
<!-- FAQ End -->
@endsection