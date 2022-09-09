@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events /</span> Calendar</h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <h5 class="card-header">Upcoming Events Calendar</h5>
                <!-- Account -->
                <div class="card-body">
                    <div id="calendarView"></div>
                </div>
                <hr class="my-0" />

                <!-- /Account -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="mb-4">
                    <h5 class="card-header">
                        Events List
                    </h5>
                    <div class="card-body">
                        <p class="text-danger">Event Not Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection


@push("custom_css")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
@endpush


@push("custom_script")
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendarView');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
</script>

@endpush