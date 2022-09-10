@extends("frontend.theme.master")
@section("content")
<x-banner style="background-image: url({{ asset('assets/images/menu/banners/guru-parampara-banner.jpg') }})">
</x-banner>


<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <div class="container">
        <div class="row sigma_broadcast-video">
            <div class="col-12 mb-5">
                <img src="{{ asset('assets/images/menu/guru-lineage.jpg') }}" class="img-fluid w-100" />
            </div>
        </div>
    </div>
</div>
@endsection