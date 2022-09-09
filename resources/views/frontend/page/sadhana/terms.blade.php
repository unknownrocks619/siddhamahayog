@extends("frontend.theme.master")
@section("content")
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
            <div class="col-md-12 mx-auto ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Terms & Condition</h4>
                        <p>
                            The quick brown fox jumps over a lazy dog.
                        </p>
                    </div>

                    <div class="card footer">
                        <form class="d-block" action="" method="get">
                            <input type="hidden" name="terms" class="d-none" value="1" />
                            <button type="submit" class="btn btn-primary w-100">I Agree</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection