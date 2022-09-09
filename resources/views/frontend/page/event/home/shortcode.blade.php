@php
$events = App\Models\WebsiteEvents::select(["slug","event_title","event_type","short_description","featured_image","full_address","status"])
->where('completed',false)
->latest()
->get();
@endphp
<!-- Holis Start -->
@if( $events->count())
<div class="section section-padding tirtery-bg">
    <div class="container">
        <div class="row sigma_sermon-box-wrapper">
            @foreach ($events as $event)
            <div class="col-lg-6">
                <div class="sigma_sermon-box">
                    <div class="sigma_box">
                        <span class="subtitle">{{ strtoupper($event->status) }}</span>
                        <h4 class="title mb-0">
                            <a href="event-details.html">
                                {{ $event->event_title }}
                            </a>
                        </h4>
                        <div class="sigma_sermon-info">
                            <div class="sigma_sermon-date">
                                <span>20</span>
                                Aug'21
                            </div>
                            <ul class="sigma_sermon-descr m-0">
                                <li>
                                    <i class="far fa-clock"></i>
                                    Sunday 8:00 - 9:00 am
                                </li>
                                <li>
                                    <i class="far fa-map-marker-alt"></i>
                                    {{ $event->full_address }}
                                </li>
                            </ul>
                        </div>
                        <div class="section-button d-flex align-items-center">
                            <a href="{{ route('events.event_detail',[$event->slug]) }}" class="sigma_btn-custom secondary">Join Now <i class="far fa-arrow-right"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Holis End -->
@endif