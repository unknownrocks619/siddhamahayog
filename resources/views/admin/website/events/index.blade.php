@extends("layouts.portal.app")

@section("page_title")
    :: Events
@endsection

@section("content")
    <section class="content">
        <div class="container">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <a href="{{ route('admin.website.events.events.create') }}" class="btn btn-primary">
                            Add New Event
                        </a>
                    </div>            
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <x-alert></x-alert>
                    </div>
                </div>
                <div class="row clearfix">
                    @foreach ($events as $event)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        <strong>
                                            {{ $event->event_title }}
                                        </strong>
                                        @if($event->program)
                                            -- {{ $event->event_program->program_name }}
                                        @endif
                                    </h2>
                                    <ul class="header-dropdown">
                                        <li class="dropdown">
                                            <a href="{{ route('admin.website.events.events.edit',$event->id) }}" class="btn btn-sm btn-info">
                                                <i class="zmdi zmdi-edit"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <form onsubmit="return confirm('You are about the delete an event. Are you Sure !! This action cannot be undone.')" style="display:inline" action="{{ route('admin.website.events.events.destroy',$event->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-sm btn-danger px-2 ">
                                                    <i class="zmdi zmdi-close"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                    <p>
                                        <strong>
                                            Start Date & Time: 
                                        </strong>
                                        {{ $event->event_start_date }}
                                        <br />
                                        <strong>
                                            End Date & Time : 
                                        </strong>
                                        {{ $event->event_end_date }}
                                        <br />
                                        <strong>Contact Person: </strong>
                                        {{ $event->event_contact_person }}
                                        <br />
                                        <strong>
                                            Contact Phone:
                                        </strong>
                                        {{ $event->event_contact_phone }}
                                        <br />
                                    </p>
                                    <hr />
                                    @if($event->status == "completed")
                                        <button type="button" class="btn btn-sm btn-block btn-success">Completed</button>
                                    @elseif ($event->status == "upcoming")
                                        <button type="button" class="btn btn-sm btn-block btn-info">Upcoming</button>
                                    @elseif ($event->status == "ongoing")
                                    <button type="button" class="btn btn-sm btn-block btn-primary">Ongoing</button>

                                    @else
                                    <button type="button" class="btn btn-sm btn-block btn-warning">Pending</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js --> 
@endsection