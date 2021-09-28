@extends("layouts.guest")

@section("style")

@endsection

@section("content")
    <div class='container'>
        <div class='row '>
            <div class='col-md-12 text-center'>
                <h4>Select Language</h4>
            </div>
            <x-alert></x-alert>
            <form method="post" action="{{ route('set-locale') }}" class='mx-auto'>
                @csrf
                <div class='row d-flex justify-content-center'>
                    <div class='col-md-4'>
                        <div class='card'>
                            <img src='{{ asset("en.svg") }}' class='img-fluid' />
                            <div class='card-header'>
                                <input type="radio" name="lang" value='en' />
                                English
                            </div>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='card'>
                            <img src='{{ asset("np.png") }}' class='img-fluid' style="max-height:180px;width:214px;margin:auto" />
                            <div class='card-header'>
                                <input type="radio" name="lang" value='np' />
                                Nepali
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row text-center mt-4'>
                    <div class='col-md-12'>
                        <input type="submit" class='btn btn-block btn-primary' value="Choose Langauge / भाषा सेट गर्नुहाेस " />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

