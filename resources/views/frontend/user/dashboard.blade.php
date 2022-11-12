@extends("frontend.theme.portal")


@section("content")

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <x-alert></x-alert>
        @include("frontend.user.dashboard.incomplete")
    </div>
    <div class="row">
        @if(user()->created_at->isToday())
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
                            <img src="{{ asset('profile/dashboard.gif') }}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @include("frontend.user.notices.dashboard")
        <!-- Order Statistics -->
        <div class="col-md-8 col-lg-8 col-xl-8 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Live Sessions</h5>
                    </div>
                </div>
                @include("frontend.user.dashboard.live-session",["enrolledPrograms" => $enrolledPrograms])
            </div>
        </div>
        <!--/ Order Statistics -->

        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
            </div>
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
                                    $notes = \App\Models\MemberNotes::where('member_id', user()->id)->latest()->first();
                                    if (!$notes) {
                                        echo "<p class='text-info'>You don't have any notes yet.</p>";
                                    }
                                    ?>
                                    @if($notes)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $notes->title }}</h6>
                                                <small class="text-muted">Continue Notes</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold"><a href="{{ route('user.account.notes.notes.edit',$notes->id) }}">Edit</a></small>
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
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Are you confused or have a problem ?</h6>
                                                <small class="text-muted">Notice</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold"><button data-href="{{ route('user.account.support.ticket.create') }}" class="btn btn-outline-primary btn-sm">Create a Support Ticket</button></small>
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

        <!-- Total Revenue -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Event Calendar</h5>
                        <div id="calendar" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5>
                        Donation
                    </h5>
                    @if(site_settings('donation') || user()->role_id == 1)
                    <form method="post" action="{{ route('donations.donate',['esewa']) }}" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <span class="input-group-text">NRs</span>
                            <input name="amount" type="text" require class="form-control" placeholder="Amount" aria-label="Amount">
                            <span class="input-group-text">.00</span>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">E-Sewa Dakshina</button>
                    </form>
                    @endif
                </div>

                <hr />
                <h5 class="text-center">
                    Your Donation History
                    <br />
                    <small>[<a href="" class="refresh-donation">Refresh list</a>]</small>
                </h5>
                <div id="dontaionTable" class="table-responsive">
                    <div class="progress mt-5" style="height:25px">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 100%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->

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
@endsection




@push("custom_css")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>

</style>
@endpush

@push("custom_script")
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });

    document.getElementsByClassName('refresh-donation')[0].addEventListener("click", (event) => {
        event.preventDefault();
        donation();
    })

    setTimeout(function() {
        donation();
    }, 10000);

    function donation() {
        $.ajax({
            url: "{{ route('donations.dashboard') }}",
            success: function(response) {
                $("#dontaionTable").html(response);
            }
        })
    }
</script>
@if(user()->role_id == 8)
<script type='text/javascript'>
    $('form#joinSessionForm').submit(function(event) {
        event.preventDefault();
        $("#userPopOption").modal('show');
        let formAction = $(this).attr('action');
        console.log(formAction);
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
@endpush