<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Himalayan Siddhababa Spiritual Academy::Vedanta Darshan::Registratioon Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style type="text/css">
        :root {
            --background: linear-gradient(180deg, #ffefe2 100%, #ffffff 85%);
            --nav-background: #4c2743;
            --main: #4c2743;
            --nav-link: #fd816a;
            --nav-link-hover: #fff0e3;
        }

        body {
            background-color: transparent;
            background-image: var(--background);
        }

        nav {
            background-color: var(--nav-background);
        }

        .theme-text {
            color: var(--main);
        }

        ul.navbar-nav>li {
            color: var(--nav-link) !important;
            letter-spacing: 0.5px;
            margin: auto 12px;
            text-transform: uppercase !important;
        }

        ul.navbar-nav>li>a {
            color: var(--nav-link) !important;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase !important;
        }

        ul.navbar-nav>li>a:hover {
            color: var(--nav-link-hover) !important;
        }

        .dropdown-menu>li>a:hover {
            color: var(--nav-link-hover) !important;
            background: transparent;
        }

        .hover-text {
            color: var(--nav-link-hover) !important;
        }

        .border-theme {
            border-color: var(--nav-background) !important;
        }

        .btn-pink-moon {
            background: #ec008c;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #fc6767, #ec008c);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #fc6767, #ec008c);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: #fff;
            border: 3px solid #eee;
        }

        .btn-orange-moon {
            background: #fc4a1a;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #f7b733, #fc4a1a);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #f7b733, #fc4a1a);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: #fff;
            border: 3px solid #eee;
        }
    </style>
</head>


<body>
    <div class="container d-none d-md-block">
        <div class="row py-2">
            <div class="col-md-3 d-flex justify-content-center align-items-center">
                <img src="https://psmyoga.ca/wp-content/uploads/2021/02/LogoT-e1621667004612-150x150.png" class="img-responsive" style="height:95px; width:95px;" />
                <h4 class="theme-text fs-3 fw-bold ms-2 d-none d-md-block d-lg-block d-xl-block">
                    हिमालयन सिद्धमहयोग
                </h4>
            </div>

            <div class="col-md-9 d-flex justify-content-end align-items-center">
                @guest
                <div class="col-md-8 d-flex justify-content-end">
                    <button type="button" class="btn border-none btn-pink-moon fs-4 clickable" data-href="{{ route('login') }}">
                        Sign In
                    </button>
                    <button type="button" class="btn border-none btn-pink-moon fs-4 clickable" data-href="{{ route('register') }}">
                        Register
                    </button>
                </div>
                @else
                <div class="col-md-8 d-flex justify-content-end">
                    <button type="button" class="btn border-none btn-pink-moon w-50 fs-4 clickable" data-href="{{ route('dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(133, 95, 95, 1);transform: ;msFilter:;">
                            <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z"></path>
                        </svg>
                        Dashboard
                    </button>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn border-none btn-orange-moon w-100 fs-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(133, 95, 95, 1);transform: ;msFilter:;">
                                <path d="m2 12 5 4v-3h9v-2H7V8z"></path>
                                <path d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <nav id="navbar_main" class="d-block d-sm-none mobile-offcanvas navbar navbar-expand-lg navbar-light p-0 w-100 nav">
        <div class="row  d-flex justify-content-end align-items-center">
            <div class="col">
                <a class="navbar-text" href="#">
                    <img src="https://psmyoga.ca/wp-content/uploads/2021/02/LogoT-e1621667004612-150x150.png" class="ps-3 py-2" height="90" />
                </a>
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" width="35px" height="35px">
                        <g id="surface132455688">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,99.607843%,99.607843%);fill-opacity:1;" d="M 0 7.5 L 0 12.5 L 50 12.5 L 50 7.5 Z M 0 22.5 L 0 27.5 L 50 27.5 L 50 22.5 Z M 0 37.5 L 0 42.5 L 50 42.5 L 50 37.5 Z M 0 37.5 " />
                        </g>
                    </svg>
                </button>

                <button class="navbar-toggler close-bar d-none pe-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(236, 230, 230, 1);transform: ;msFilter:;">
                        <path d="M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 19V7h16l.001 12H4z"></path>
                        <path d="m15.707 10.707-1.414-1.414L12 11.586 9.707 9.293l-1.414 1.414L10.586 13l-2.293 2.293 1.414 1.414L12 14.414l2.293 2.293 1.414-1.414L13.414 13z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="navbarSupportedContent" class="navbar-collapse collapse">
            <ul class="navbar-nav align-items-center" style="flex-wrap: wrap;margin-left:10px;">
                @guest
                <li class="nav-item">
                    <a class="nav-link active clickable" data-href="{{ route('login') }}" href="#">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active clickable" data-href="{{ route('register') }}" href="#">Register</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link active clickable" data-href="{{ route('dashboard') }}" href="#">Dashboard</a>
                </li>

                @endguest
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="https://siddhamahayog.org">होम पेज</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://siddhamahayog.org">हाम्रो बारे</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="https://siddhamahayog.org" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        कार्यक्रमहरू
                    </a>
                    <ul class="dropdown-menu theme-text py-2" style="background-color: var(--nav-background);">
                        <li><a class="dropdown-item py-2" style="color:var(--nav-link)" href="https://siddhamahayog.org">जगद्गुरू श्रीरामानन्दाचार्य सेवा पीठ​</a></li>
                        <li><a class="dropdown-item" style="color:var(--nav-link)" href="https://siddhamahayog.org">वेदान्त दर्शन</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ग्यालेरी</a>
                </li>
                <li class="nav-item" href="#">
                    विशेष कार्यक्रमहरू
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">सम्पर्क</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Donate</a>
                </li>
                <li class="nav-item mt-3 border-top">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-link hover-text text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(133, 95, 95, 1);transform: ;msFilter:;">
                                <path d="m2 12 5 4v-3h9v-2H7V8z"></path>
                                <path d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /Mobile -->

    <nav class="d-none d-md-block d-lg-block navbar navbar-expand-lg">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="https://siddhamahayog.org">होम पेज</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://siddhamahayog.org">हाम्रो बारे</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://siddhamahayog.org" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            कार्यक्रमहरू
                        </a>
                        <ul class="dropdown-menu theme-text py-2" style="background-color: var(--nav-background);">
                            <li><a class="dropdown-item py-2" style="color:var(--nav-link)" href="https://siddhamahayog.org">जगद्गुरू श्रीरामानन्दाचार्य सेवा पीठ​</a></li>
                            <li><a class="dropdown-item" style="color:var(--nav-link)" href="https://siddhamahayog.org">वेदान्त दर्शन</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ग्यालेरी</a>
                    </li>
                    <li class="nav-item" href="#">
                        विशेष कार्यक्रमहरू
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">सम्पर्क</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Donate</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ps-0 ms-0">
                <img class="img-fluid h-100 d-none d-md-block" src="https://psmyoga.ca/wp-content/uploads/2021/05/gurudevWBG-580x1024.jpg" />
            </div>
            <div class="col-md-9">
                <div class="alert alert-danger d-none" id="errorMessage"></div>
                <form id="vendantaRegistration" action="{{ route('vedanta.store') }}" method="post">
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-center">
                            <h2 class="theme-text fw-bold border-bottom pb-3">हिमालयन सिद्घमहायोग - वेदान्त दर्शन</h2>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <p class="d-block text-center fs-3">
                            Your form for <code>Vedanta Darshan</code> has already been submitted.
                        </p>
                        <div class="col-md-12 d-flex justify-content-center">
                            <button data-href='{{ route("dashboard",["ref" => "_form"]) }}' class="clickable btn btn-success px-5 py-3 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z"></path>
                                </svg>
                                GO TO DASHBORD</button>
                            <?php
                            $transaction = auth()->user()->transactions()->first();

                            if (!$transaction || $transaction->rejected) {
                                echo "<button data-href='" . route("user.account.programs.program.index") . "' class=' clickable btn btn-danger px-5 py-3'>DEPOSIT ADMISSION FEE</button>";
                            }

                            if ($transaction && $transaction->amount < 9000) {
                                echo "<button data-href='" . route("user.account.programs.program.index") . "'  class='clickable btn btn-warning px-5 py-3'>PAY REMAINING FEE</button>";
                            }
                            ?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $(".clickable").click(function(event) {
                event.preventDefault();
                $(this).attr('disabled', true);
                window.location.href = $(this).data('href');
            });
        })
        $('form#vendantaRegistration').submit(function(event) {
            event.preventDefault();
            return formSubmit(this);
        })

        function formSubmit(formElement) {
            $.ajax({
                method: $(formElement).attr('method'),
                url: $(formElement).attr('action'),
                data: $(formElement).serializeArray(),
                beforeSend: function() {
                    removeErrorFields(formElement);
                    propStatus(formElement, true);
                },
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
                },
                success: function(response) {
                    propStatus(formElement, false);
                    let parentElem = $(formElement).parent();
                    $(parentElem).empty().html(response);

                },
                error: function(response) {
                    propStatus(formElement, false)

                    if (response.status == 419) {
                        window.location.reload();
                    }

                    if (response.status == 422) {
                        return errorFields(response.responseJSON.errors, formElement);
                    }
                }
            })
        }


        function errorFields(errors, elem) {
            var noMessagebox = false;
            $.each(errors, function(index, error) {
                let inputElement = $(elem).find(`[name="${index}"]`);
                if ($(inputElement).length) {
                    $(inputElement).addClass('border border-danger');
                    // also create new element.
                    let errorElement = `<div class='text-danger formError' data-id="${index}">${error}</div>`
                    $(inputElement).closest('div.form-group').append(errorElement);
                } else {
                    noMessagebox = true
                }

            })

            if (noMessagebox) {
                $("#errorMessage").html("Oops ! something went wrong please try again.");
            }

        }

        function removeErrorFields(elem) {
            $("#errorMessage").empty().addClass('d-none');
            $(elem).find('input').removeClass('border border-danger');
            $(elem).find('textarea').removeClass('border border-danger');
            $(elem).find('select').removeClass('border border-danger');
            $(elem).find('div.formError').remove();
        }

        function propStatus(elem, value) {
            $(elem).find('input').prop('disabled', value);
            $(elem).find('select').prop('disabled', value);
            $(elem).find('button').prop('disabled', value);
            $(elem).find('textarea').prop('disabled', value);
        }
    </script>
</body>

</html>