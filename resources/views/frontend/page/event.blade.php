@extends("frontend.theme.master")

@section('content')
@include("frontend.page.event.banner",["event"=>$event]);


<!-- Post Content Start -->
<div class="section sigma_post-single">
    <div class="container">

        <div class="row">

            <div class="col-lg-8">
                <div class="post-detail-wrapper">

                    <div class="entry-content">
                        @include("frontend.page.event.event_gallery",["event" => $event])

                        <h4>{{ $event->event_title }}
                            <h4>
                                <div class="sigma_post-meta">
                                    <a href="#"> <i class="far fa-clock"></i> Sunday (8:00 am -9:00 am)</a>
                                    <a href="#"> <i class="far fa-map-marker-alt"></i> 56 Thatcher Avenue River Forest</a>
                                </div>
                                {!! $event->full_description !!}

                                @if($event->widget())
                                @foreach ($event->widget()->get() as $widget)
                                @include("frontend.widgets.$widget->widget_type",["widget" => $widget]);
                                @endforeach
                                @endif
                                <blockquote>
                                    <cite>By Hetmayar</cite>
                                    <p>Some Hindu teachers insist that believing in rebirth is necessary for living an ethical life. Their concern is that if there is no fear of karmic repercussions in future lifetimes</p>
                                </blockquote>
                                
                    </div>

                    <!-- Post Meta Start -->
                    <div class="sigma_post-single-meta">
                        <div class="sigma_post-single-meta-item sigma_post-share">
                            <h6>Share</h6>
                            <ul class="sigma_sm">
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Post Meta End -->

                    <!-- Post Pagination Start -->
                    <div class="section">

                    </div>
                    <!-- Post Pagination End -->

                    <!-- Comments Start -->
                    <div class="section">
                        <h5>03 Comments</h5>
                        <div class="comments-list">
                            <ul>
                                <li class="comment-item">
                                    <img src="assets/img/blog/details/7.jpg" alt="comment author">
                                    <div class="comment-body">
                                        <h5>Robert John</h5>
                                        <span> <i class="far fa-clock"></i> January 13 2022</span>
                                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition.</p>
                                        <a href="#" class="btn-link"> Reply <i class="far fa-reply"></i> </a>
                                    </div>
                                </li>
                                <li class="comment-item">
                                    <img src="assets/img/blog/details/8.jpg" alt="comment author">
                                    <div class="comment-body">
                                        <h5>Christine Hill</h5>
                                        <span> <i class="far fa-clock"></i> December 27 2022</span>
                                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches</p>
                                        <a href="#" class="btn-link"> Reply <i class="far fa-reply"></i> </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="section">
                        <h5>Leave a Comment</h5>
                        <div class="comment-form">
                            <form method="post">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Enter your Message" name="comment" rows="7"></textarea>
                                </div>
                                <div class="form-group">
                                    <i class="far fa-user custom-primary"></i>
                                    <input type="text" placeholder="Full Name" class="form-control" name="fname" value="">
                                </div>
                                <div class="form-group">
                                    <i class="far fa-envelope custom-primary"></i>
                                    <input type="email" placeholder="Email Address" class="form-control" name="email" value="">
                                </div>
                                <div class="form-group">
                                    <i class="far fa-globe custom-primary"></i>
                                    <input type="text" placeholder="Website" class="form-control" name="website" value="">
                                </div>
                                <button type="submit" class="sigma_btn-custom" name="button">Post Comment <i class="far fa-comments"></i> </button>

                            </form>
                        </div>
                    </div>
                    <!-- Comments End -->

                </div>
            </div>

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <div class="sidebar">

                    @include("frontend.page.event.information",["event"=>$event])
                    <!-- Categories Start -->
                    <div class="sidebar-widget widget-upcoming-events">
                        <h5 class="widget-title"> Donation </h5>
                        <ul>
                            <li>
                                <div class="date">
                                    <span>20</span>
                                    Aug'21
                                </div>
                                <div class="event-name">
                                    <h6>Weekly Evening Prayer</h6>
                                    <p>Wednesday | 6:00 pm</p>
                                </div>
                            </li>
                            <li>
                                <div class="date">
                                    <span>12</span>
                                    Sep'21
                                </div>
                                <div class="event-name">
                                    <h6>Staff Members Meet</h6>
                                    <p>Thursday | 8:00 pm</p>
                                </div>
                            </li>
                            <li>
                                <div class="date">
                                    <span>20</span>
                                    Nov'15
                                </div>
                                <div class="event-name">
                                    <h6>Weekly Evening Prayer</h6>
                                    <p>Monday | 4:00 pm</p>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="events.html" class="sigma_btn-custom mt-4">See All</a>
                        </div>

                    </div>
                    <!-- Categories End -->

                    <!-- Social Media Start -->
                    <div class="sidebar-widget">
                        <h5 class="widget-title">Never Miss Out</h5>
                        <ul class="sigma_sm square light">
                            <li>
                                <a href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Social Media End -->

                </div>
            </div>
            <!-- Sidebar End -->

        </div>

    </div>
</div>
<!-- Post Content End -->
@endsection