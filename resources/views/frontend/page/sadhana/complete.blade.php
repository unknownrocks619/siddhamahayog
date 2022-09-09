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
    <form action="{{ route('sadhana.store.history') }}" method="post">
        @csrf
        @google_captcha()
        <div class="container">
            <div class="row sigma_broadcast-video my-3">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">
                                {{ __("sadhana.sadhana_congratulation") }}
                            </h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <x-alert></x-alert>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push("page_script")
<script type="text/javascript">
    setTimeout(function() {
        window.location.href = '{{ route("dashboard") }}';
    }, 5000);
</script>
@endpush