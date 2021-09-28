<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siddhamahayog Dhayan Sadhana Kendra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    @yield("style")
</head>
    <body>
        <div class='container'>

            <div class='row mt-2'>
                <div class='col-xs-12 col-md-12 text-center'>
                    <h2>
                        सिद्धमहायाेग ध्यान साधना केन्द्र
                        <br />
                        <span style="font-size:26px">जगदगुरु श्रीरामानन्दाचार्य सेवापीठ</span>
                    </h2>
                    
                    <p>
                        मन्त्राे लयाे हठाे राजयाेगाेऽन्तर्भूमिका:क्रमात् ।
                        <br />
                        एक एव चतुर्धाय‌ं महायाेगाेऽभिधीयते ।।
                    </p>
                </div>
                @if( ! Route::currentRouteName() == "public_user_login")
                    @auth
                    
                    @else
                    <div class="col-md-12 text-center">
                        <a href="{{ route('public_user_login') }}" class='btn btn-info'>Login</a>

                    </div>
                    @endauth
                @endif
            </div>
            <div class='row'>
                @if( ! Route::currentRouteName() == "public_user_login")
                <div class='col-md-4'>
                    @if(App::currentLocale() == "en")
                        <img src='{{ asset("np.png") }}' class='img-circle' style="width:25px; height:25px" />

                        <a href="{{ route('change-language-from',['lang'=>'np']) }}">
                            पुन भाषा चयन गर्नुहाेस ।
                        </a>
                    @else
                        <img src='{{ asset("en.svg") }}' class='img-circle' style="width:25px; height:25px" />
                        <a href="{{ route('change-language-from',['lang'=>'en']) }}">
                        Change Language
                        </a>
                    @endif
                </div>
                <div class='col-md-8 d-flex justify-content-end'>
                    @if(Route::currentRouteName() == "sadhana-step-two")
                        <form method="post" action="{{ route('destroy-application',[$user->id,'close']) }}">
                            @csrf
                                <input type="submit" value='Cancel My Application' class='btn btn-link text-danger' /> 
                        </form>
                        
                        <form method="post" action="{{ route('destroy-application',[$user->id,'restart']) }}">
                            @csrf
                                <input type="submit" value='Restart My Application' class='btn btn-link text-info' /> 
                        </form>
                    @endif
                </div>
                @endif
            </div>
            @yield("content")
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
        @yield("footer_script")
    </body>
</html>