@extends('frontend.theme.portal')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <x-alert></x-alert>
            @include('frontend.user.dashboard.incomplete')
        </div>
        <div class="row">
            @if (user()->created_at->isToday())
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Congratulations {{ user()->full_name }}! 🎉</h5>
                                    <p class="mb-4">
                                        You are now a member of Himalayan Siddhamahayog Spiritual Academy.
                                    </p>

                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">View My Courses</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('profile/dashboard.gif') }}" height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('frontend.user.notices.dashboard')
            <!-- Order Statistics -->
            <div class="col-md-12 col-lg-7 col-xl-7 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Live Sessions</h5>
                        </div>
                    </div>

                    @include('frontend.user.dashboard.live-session', [
                        'enrolledPrograms' => $enrolledPrograms,
                    ])
                </div>
            </div>
            <!--/ Order Statistics -->

            <div class="col-12 col-md-6 col-lg-5 order-3 order-md-2">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Notes</h5>
                                        </div>
                                        <?php
                                        $notes = \App\Models\MemberNotes::where('member_id', user()->id)
                                            ->latest()
                                            ->first();
                                        if (!$notes) {
                                            echo "<p class='text-info'>You don't have any notes yet.</p>";
                                        }
                                        ?>
                                        @if ($notes)
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-primary"><i
                                                            class="bx bx-mobile-alt"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">{{ $notes->title }}</h6>
                                                        <small class="text-muted">Continue Notes</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small class="fw-semibold"><a
                                                                href="{{ route('user.account.notes.notes.edit', $notes->id) }}">Edit</a></small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Confused</h5>
                                        </div>

                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary"><i
                                                        class="bx bx-mobile-alt"></i></span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">Are you confused or have a problem ?</h6>
                                                    <small class="text-muted">Notice</small>
                                                </div>
                                                <div class="user-progress">
                                                    <small class="fw-semibold"><button
                                                            data-href="{{ route('user.account.support.ticket.create') }}"
                                                            class="btn btn-outline-primary btn-sm">Create a Support
                                                            Ticket</button></small>
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if (user()->role()->isTeacher())
                <div class="col-md-12 mb-3" id="">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Your Members</h4>
                            <button class="btn btn-primary">Register New Member</button>
                        </div>
                        <div class="card-body">
                            <div id="memberRegistration">
                                <form
                                    onsubmit="event.preventDefault();window.registration.verifyRegistrationProcess(this,'{{ encrypt(auth()->guard('web')->id()) }}')"
                                    action="{{ route('user.register-token') }}" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <select onchange="changeCountry(this); window.registration.setAttribute(this)"
                                                name="country" id="country" class="form-control">
                                                @foreach (\App\Models\Country::get() as $country)
                                                    <option @if ($country->code == 'NP') selected @endif
                                                        value="{{ $country->getKey() }}" data-
                                                        title="{{ strtoupper($country->code) }}">{{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 country-verification country-nepal mt-2">
                                            <div class="form-group">
                                                <div class="input-group" style="height: 50px;">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="height: 50px"
                                                            id="basic-addon1">+977</span>
                                                    </div>
                                                    <input type="text" onchange="window.registration.setAttribute(this)"
                                                        name="phone" id="phone" class="form-control"
                                                        placeholder="98XXXXXXXX">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 country-verification country-other mt-2" style="display:none">
                                            <div class="form-group">
                                                <div class="input-group" style="height: 50px;">
                                                    <span class="input-group-text" style="height: 50px"
                                                        id="basic-addon1">Email</span>
                                                    <input type="email"
                                                        onchange="window.registration.setAttribute(this)" name="email"
                                                        id="email" class="form-control"
                                                        placeholder="youremail@gmail.com">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 country-verification country-nepal">
                                            <div class="form-group">
                                                <div class="form-check form-check-primary mt-4">
                                                    <label class="form-check-label" for="email_option">Use Email
                                                        Instead</label>
                                                    <input class="form-check-input"
                                                        onchange="changeCountry(this,'.country-other');window.registration.setAttribute(this)"
                                                        type="checkbox" name="email_option" value="1"
                                                        id="email_option" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-primary">
                                                Proceed
                                                <i class="menu-icon tf-icons bx bxs-right-arrow bx-tada-hover"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="underLinksMembersLists"
                                    data-action="">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Registration Date</th>
                                            <th>Training</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach (user()->mySession()->get() as $memberSession)
                                            @foreach ($memberSession->enrolledUsers ?? [] as $member)
                                                <tr>

                                                    <td>
                                                        {{ !empty($member->full_name) ? $member->full_name : $member->full_name() }}
                                                    </td>
                                                    <td>
                                                        {{ $member->phone_number ?? 'Add Phone Number' }}
                                                    </td>
                                                    <td>
                                                        {{ $member->email ? $member->email : 'Add Email' }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $member->created_at->format('Y,M d') }}
                                                    </td>
                                                    <td>
                                                        <Strong>
                                                            {{ $memberSession->course_group_name }}
                                                        </Strong>
                                                        <br />
                                                        {{ $memberSession->training_location }}
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-icon btn-primary"><i
                                                                class="menu-icon bx bx-pencil me-0"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            @endif
            <!-- Total Revenue -->
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <div id="calendar" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            {{-- @include('views.frontend.user.dashboard.donation') --}}

            <!-- Transactions -->
            <div class="col-md-12 col-lg-12 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Your Assignments</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">You don't have any assignment</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Transactions -->
        </div>
    </div>
    <!-- Content wrapper -->
    <x-modal modal='responsiveContent'></x-modal>
    <x-modal modal='yagyaInformation'></x-modal>

@endsection

@push('custom_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        .fc-next-button {
            display: none !important;
        }

        .fc-prev-button {
            display: none !important;
        }

        .fc-event-main {
            background: #9f3a0a !important;
            color: #fff !important;
            font-size: 15px;
        }

        .select2-selection--single {
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            font-size: 24px;
        }

        .select2-selection__arrow {
            top: 30% !important;
        }
    </style>
@endpush

@push('custom_script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" />
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                eventDidMount: function(info) {
                    console.log('info: ', info.event.title)
                    var tooltip = new bootstrap.Tooltip(info.el, {
                        title: info.event.extendedProps.description ?? info.event.title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                },
                events: [{
                        id: '01',
                        groupId: 'ekadashi',
                        title: 'Ekadashi',
                        start: '2023-02-01',
                        allDay: true,
                        background: 'green'
                    },
                    {
                        id: '05',
                        groupId: 'purnima',
                        title: 'Purnima',
                        allDay: true,
                        start: '2023-02-05'
                    },
                    {
                        id: '06',
                        groupId: 'pratipada',
                        title: 'Pratipada',
                        allDay: true,
                        start: '2023-02-06'
                    },
                    {
                        id: '12',
                        groupID: 'gurudev-vardapan-mahtosav',
                        title: 'Gurudev Vardapan Mahtosav (Tithi)',
                        allDay: true,
                        start: '2023-02-12'
                    },
                    {
                        title: 'Astami/Sankranti',
                        id: '13',
                        groupID: 'astami-sankranti',
                        start: '2023-02-13',
                        allDay: true,
                        resourceIds: ['a']
                    },
                    {
                        id: '16',
                        groupId: 'ekadashi',
                        start: '2023-02-16',
                        allDay: true,
                        title: 'Ekadashi',
                    },
                    {
                        id: '18',
                        groupID: 'maha-shivaratri',
                        start: '2023-02-18',
                        allDay: true,
                        title: 'Maha Shivaratri'
                    },
                    {
                        id: '20',
                        groupID: 'aaunsi',
                        start: '2023-02-20',
                        title: 'Aaunsi',
                        allDay: true
                    },
                    {
                        id: "21",
                        groupId: 'pratipada',
                        title: 'Pratipada',
                        start: '2023-02-21',
                        allDay: true
                    },
                    {
                        id: '27',
                        title: 'Astami',
                        allDay: true,
                        start: '2023-02-27',
                        groupId: 'astami',
                        resourceIds: ['a']
                    }
                ],

                resources: [{
                    id: 'a',
                    title: "Astami"
                }]

            });
            calendar.render();
        });

        // document.getElementsByClassName('refresh-donation')[0].addEventListener("click", (event) => {
        //     event.preventDefault();
        //     donation();
        // })

        // setTimeout(function() {
        //     donation();
        // }, 10000);

        // function donation() {
        //     $.ajax({
        //         url: "{{-- route('donations.dashboard') --}}",
        //         success: function(response) {
        //             $("#dontaionTable").html(response);
        //         }
        //     })
        // }
    </script>
    @if (user()->role_id == 8)
        <script type='text/javascript'>
            $('form#joinSessionForm').submit(function(event) {
                event.preventDefault();
                $("#userPopOption").modal('show');
                let formAction = $(this).attr('action');

                $("#userPopOption").find('form').attr('action', formAction);
            });
        </script>
    @else
        <script type='text/javascript'>
            $('#joinSessionForm').submit(function(event) {
                event.preventDefault();
                $(this).find('button').prop('disabled', true);
                $("form#joinSessionForm")[0].submit();
            });
        </script>
    @endif


    @if (\App\Models\Role::ACTING_ADMIN == user()->role_id || \App\Models\Role::SUPER_ADMIN == user()->role_id)
        <script type="text/javascript">
            $('#goLive').on('shown.bs.modal', function(event) {
                $.ajax({
                    method: "get",
                    url: event.relatedTarget.href,
                    dataType: 'html',
                    success: function(success) {
                        $("#modal_content").html(success);
                    }
                })
            })
        </script>
    @endif
    <script type="text/javascript">
        function JoinLiveSession(submissionMethod, submissionUrl, SubmissionData = []) {
            $.ajax({
                method: submissionMethod,
                url: submissionUrl,
                data: SubmissionData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    handleOKResponse(response)
                },
                error: function(response) {
                    handleBadResponse(response);

                }
            })
        }

        function revertText(element, originalText, disable = false) {
            $(element).text(originalText).prop('disable', disable);
        }

        $(document).on('submit', 'form.confirm-join-session', function(event) {
            event.preventDefault();
            $(this).find('button').prop('disabled', true);
            JoinLiveSession($(this).attr('method'), $(this).attr('action'), $(this).serializeArray());
        })

        $(document).on('click', '.live-session-button', function(event) {
            event.preventDefault();
            let _this = this;
            let previousText = $(_this).text();
            $(_this).prop('disabled', true).text('please wait...');
            JoinLiveSession($(_this).data('method'), $(_this).data('action'));
            setTimeout(() => {
                $(_this).prop('disabled', false).text(previousText);
            }, 10000);

        })

        window.handleOKResponse = function(response) {
            if (response.status == 200) {
                messageBox(response.state, response.msg);

                if ((response.callback !== null || response.callback !== '')) {
                    let fn = window[response.callback];

                    if (typeof(fn) === 'function') {
                        fn(response.params);
                    }
                }
            }
        }

        window.handleBadResponse = function(response) {
            clearAllErrors();
            if (response.status == 422) {
                handle422Case(response.responseJSON);
            }
        }

        window.handle422Case = function(data) {
            messageBox(false, data.msg ? data.msg : data.message);
            $.each(data.errors, function(index, error) {
                let inputElement = $(`input[name="${index}"]`);
                let parentDiv = $(inputElement).closest('div.form-group');

                if (parentDiv.length) {
                    let element = `<div class='text-danger ajax-response-error'>${error}</div>`
                    parentDiv.append(element);
                }
            });
        }

        window.redirect = function(param) {

            if (typeof param.location !== 'undefined' || param.location !== null) {
                window.location.href = param.location
            }
        }

        window.reload = function() {
            window.location.reload();
        }

        window.messageBox = function(status, message, icon = null) {
            if (!message || message == null || message == undefined) {
                return;
            }
            if (!icon && status == false) {
                icon = "<i class='fa fa-warning'></i>";
            } else if (!icon && status == true) {
                icon = "<i class='fa fa-check-square'></i>";
            }


            $.notify(`${icon}<strong>${message}</strong>`, {
                type: (status) ? 'success' : 'danger',
                allow_dismiss: true,
                showProgressbar: true,
                autoHide: false,
                timer: 100,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        }

        window.popModalWithHTML = function(params) {
            let _targetID = params.modalID;
            if (!$('#' + _targetID).length) {
                messageBox(false, 'Unable to complete your action.');
                return;
            }

            let _modalElement = $('#' + _targetID);
            $(_modalElement).find('#modal-content').empty().html(params.content);
            // now trigger modal pop.
            $("#" + _targetID).modal('toggle');

            if (params.clearButton) {
                $('.' + params.clearButton).prop('disable', false).text(params.label ?? 'Join Now');
            }
        }

        window.clearAllErrors = function() {
            $('.ajax-response-error').remove();
        }
    </script>

    <script>
        function cancelParticipants() {
            $.ajax({
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('frontend.jaap.cancel-jap-info') }}',
            })
        }
    </script>

    @if (user()->role()->isTeacher())
        <script>
            $(() => {
                $('#country').select2({
                    templateResult: function(item) {
                        return format(item);
                    }
                });

                function format(item) {

                    let url = "https://flagsapi.com/" + item.title + "/flat/64.png";
                    let img = $("<img>", {
                        class: "img-flag me-2 py-1",
                        width: 45,
                        src: url
                    });

                    let span = $("<span>", {
                        text: " " + item.text,
                        class: "fs-4"
                    });
                    span.prepend(img);
                    return span;

                }
            });

            function changeCountry(elm, targetElm = '') {
                if (targetElm !== '') {
                    $(targetElm).toggle();
                    return;
                }

                $('.country-verification').hide();

                if ($(elm).find(':selected').val() != '153') {
                    $('.country-other').show();
                    $('#email_option').removeAttr('checked');
                } else {
                    $('.country-nepal').show();

                }
            }
        </script>
    @endif
@endpush
