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

        .border-theme {
            border-color: var(--nav-background) !important;
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="row py-2">
            <div class="col-md-3 d-flex justify-content-between align-items-center">
                <img src="https://psmyoga.ca/wp-content/uploads/2021/02/LogoT-e1621667004612-150x150.png" class="img-responsive" style="height:95px; width:95px;" />
                <h4 class="theme-text fs-3 fw-bold ms-2 d-none d-md-block d-lg-block d-xl-block">
                    हिमालयन सिद्धमहयोग
                </h4>

            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Programs
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Donate</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ps-0 ms-0">
                <img class="img-fluid h-100" src="https://psmyoga.ca/wp-content/uploads/2021/05/gurudevWBG-580x1024.jpg" />
            </div>
            <div class="col-md-9">
                <div class="alert alert-danger d-none" id="errorMessage"></div>
                <form id="vendantaRegistration" action="{{ route('vedanta.store') }}" method="post">
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-center">
                            <h2 class="theme-text fw-bold">हिमालयन सिद्घमहायोग - वेदान्त दर्शन</h2>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-7 border-end border-theme">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="theme-text">
                                        Basic Information
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name">First Name
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" value="{{ $user_record['first_name'] ?? '' }}" name="first_name" id="first_name" class="mt-2 form-control @error('first_name') border border-danger @enderror" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_name">Middle Name
                                        </label>
                                        <input type="text" value="{{ $user_record['middle_name'] ?? '' }}" name="middle_name" id="middle_name" class="mt-2 form-control @error('middle_name') border border-danger @enderror" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name">Last Name
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" value="{{ $user_record['last_name'] ?? '' }}" name="last_name" id="last_name" class="mt-2 form-control @error('last_name') border border-danger @enderror" />

                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="gender">Gender
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male" @if(isset($user_record['gender']) && $user_record['gender']=='male' ) selected @endif>Male</option>
                                            <option value="female" @if(isset($user_record['gender']) && $user_record['gender']=='female' ) selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="phone_number">Mobile Number
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" value="{{ $user_record['phone_number'] ?? '' }}" name="phone_number" id="phone_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="country">
                                            Country
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="country" id="country" class="form-control">
                                            <?php
                                            $countries = \App\Models\Country::get();
                                            ?>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->getKey() }}" @if(isset($user_record['country']) && $user_record['country']==$country->getKey()) selected @endif>
                                                {{ $country->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="state">
                                            State
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" value="{{ $user_record['state'] ?? '' }}" name="state" id="state" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group"><label for="address">Street Address</label>
                                        <textarea name="street_address" id="street_address" class="form-control">{{ $user_record['street_address'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="date_of_birth">
                                            Date of Birth
                                        </label>
                                        <input type="date" value="{{ $user_record['date_of_birth'] ?? '' }}" name="date_of_birth" id="date_of_birth" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="date_of_birth">
                                            Place of Birth
                                        </label>
                                        <input type="text" name="place_of_birth" value="{{ $user_record['place_of_birth'] }}" id="place_of_birth" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="education">Your Highest Education
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="education" id="education" class="form-control ">
                                            <option value="primary" @if(isset($user_record['education']) && $user_record['education']=='primary' ) selected @endif>Primary</option>
                                            <option value="secondary" @if(isset($user_record['education']) && $user_record['education']=='secondary' ) selected @endif>Secondary (1-20 Class)</option>
                                            <option value="higher_secondary" @if(isset($user_record['higher_secondary']) && $user_record['education']=='primary' ) selected @endif>Higher Secondary (11 - 12 Class)</option>
                                            <option value="bachelor" @if(isset($user_record['education']) && $user_record['education']=='bachelor' ) selected @endif>Bachelor</option>
                                            <option value="master" @if(isset($user_record['education']) && $user_record['education']=='master' ) selected @endif>Masters</option>
                                            <option value="phd" @if(isset($user_record['education']) && $user_record['education']=='phd' ) selected @endif>PhD</option>
                                            <option value="none" @if(isset($user_record['education']) && $user_record['education']=='none' ) selected @endif>None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="profession">Profession
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="profession" value="{{ $user_record['profession'] ?? '' }}" id="profession" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-col-md-6">
                                    <div class="form-group">
                                        <label for="field_of_study">
                                            What is your education major ?
                                            <small class="text-info">
                                                Please be as specific as possible (example: computer science, engineering etc.)
                                            </small>
                                        </label>
                                        <input value="{{ $user_record['education_major'] ?? ''}}" type="text" name="field_of_study" id="field_of_study" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 ps-2">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4 class="theme-text">
                                        Emergency Contact Information
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person">Emergency Contact Person
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="emergency_contact_person" value="{{ $user_record['emmergency_contact_name'] ?? '' }}" id="contact_person" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emergency_phone">Contact Mobile Number
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </label>
                                        <input type="text" value="{{ $user_record['emmergency_contact_number'] ?? '' }}" name="emergency_phone" id="emergency_phone" value="" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div class="form-group">
                                        <label for="emergency_contact_person_relation">Relation to Emergency Contact Person
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input value="{{ $user_record['emmergency_contact_relation'] ?? '' }}" type="text" name="emergency_contact_person_relation" id="emergency_contact_person_relation" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-md-12 mt-2">
                                    <h4 class="theme-text">
                                        Reference Detail
                                    </h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="referer_person">
                                                Referer Person
                                            </label>
                                            <input value="{{ $user_record['referer_person'] ?? '' }}" type="text" name="referer_person" id="referer_person" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="referer_relation">
                                                Relation
                                            </label>
                                            <input type="text" value="{{ $user_record['referer_relation'] ?? '' }}" name="referer_relation" id="referer_relation" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label for="referer_contact">Referer Mobile Number</label>
                                        <input type="text" value="{{ $user_record['referer_contact'] ?? '' }}" name="referer_contact" id="referer_contact" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @guest()
                                <div class="col-md-12 mt-3">
                                    <h4 class="teheme-text">
                                        Login Detail
                                    </h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="email">Email Address
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="email" name="email" id="email" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label for="email">Password
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="password" name="password" id="password" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                @endguest

                                <div class="col-md-12 mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger px-5 w-100 fs-3">
                                        Next
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
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