@extends("frontend.theme.master")
@section("content")
<x-banner style="background-image: url({{ asset('assets/images/menu/banners/atirudri-detail-banner.jpg') }})">
</x-banner>


<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <div class="container">
        <div class="row sigma_broadcast-video">
            <div class="col-12 mb-5">
                <div class="section-title mb-0 text-start">
                    <p class="subtitle">Events</p>
                    <h4 class="title">Atirudri Mahayaga</h4>
                    <p>
                        Coming Soon
                    </p>
                </div>
                <img src="{{ asset('assets/images/menu/quote-one.jpg') }}" class="img-fluid w-100" />
            </div>
        </div>
    </div>
</div>



@endsection