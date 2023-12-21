@extends("layouts.portal.app")

@section("page_title")
:: Events
@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form enctype="multipart/form-data" action="{{ route('admin.website.events.events.update',$event->id) }}" method="post">
                        @method("PUT")
                        @csrf
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <strong>
                                        Update Event Detail
                                    </strong>
                                    Event
                                </h2>
                                <ul class='header-dropdown'>
                                    <li>
                                        <a href="{{ route('admin.website.events.events.index') }}" class="btn btn-sm btn-danger">
                                            <i class="zmdi zmdi-close"></i>
                                            Close
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <strong>
                                                Event Title
                                                <sup class="text-danger">*</sup>
                                            </strong>
                                            <input type="text" value="{{ old('event_title',$event->event_title) }}" name="event_title" id="event_title" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            Event Type
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <select name="event_type" id="event_type" class="form-control">
                                            <option @if(old('event_type',$event->event_type) == "offline") selected @endif value="offline">
                                                Offline
                                            </option>
                                            <option @if(old('event_type',$event->event_type) == "online") selected @endif value="online">
                                                Online
                                            </option>
                                            <option @if(old('event_type',$event->event_type) == "live") selected @endif value="live">
                                                Live
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <strong>
                                                Event Short Description
                                            </strong>
                                            <textarea name="event_short_description" id="event_short_description">{{ old('event_short_description',$event->short_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>
                                            Event
                                        </strong>
                                        Description
                                        <textarea name="event_description" class="form-control" id="event_description">{{ old('event_description',$event->full_description) }}</textarea>
                                    </div>
                                </div>

                                <!-- featured image -->
                                <div class="row mt-3">
                                    <!-- Featured image one -->
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>
                                                    Featured Image
                                                </strong>
                                                One
                                                <span class="text-info">
                                                    Recommended Size: 218 x 260 px
                                                </span>
                                                <input type="file" name="featured_image_one" id="featured_image_one" class="form-control" />
                                            </div>
                                        </div>
                                        @if($featured_image && isset($featured_image->one) )
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="{{ asset($featured_image->one->path) }}" class="img-thumbnail img-fluid" />
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- featured image two -->
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>
                                                    Featured Image
                                                </strong>
                                                Two
                                                <span class="text-info">
                                                    Recommended Size: 403 x 481 px
                                                </span>
                                                <input type="file" name="featured_image_two" id="featured_image_two" class="form-control" />
                                            </div>
                                        </div>
                                        @if($featured_image && isset($featured_image->two) )
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="{{ asset($featured_image->two->path) }}" class="img-thumbnail img-fluid" />
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- featured image three -->
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>
                                                    Featured Image
                                                </strong>
                                                Three
                                                <span class="text-info">
                                                    Recommended Size: 168 x 200 px
                                                </span>
                                                <input type="file" name="featured_image_three" id="featured_image_three" class="form-control" />
                                            </div>
                                        </div>
                                        @if($featured_image && isset($featured_image->three) )
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="{{ asset($featured_image->three->path) }}" class="img-thumbnail img-fluid" />
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Event Contact person -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Event Start Date
                                            </strong>
                                            <input type="datetime-local" value="{{ old('event_start_date',date('Y-m-d\TH:i',strtotime($event->event_start_date))) }}" name="event_start_date" id="event_start_date" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Event End Date
                                            </strong>
                                            <input value="{{ old('event_end_date',date('Y-m-d\TH:i',strtotime($event->event_end_date))) }}" type="datetime-local" name="event_end_date" id="event_end_date" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <strong>
                                                Event Contact Phone:
                                            </strong>
                                            <input value="{{ old('event_phone_contact',$event->event_contact_phone) }}" type="text" name="event_phone_contact" id="event_phone_contact" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <strong>
                                                Event Contact Person
                                            </strong>
                                            <input type="text" value="{{ old('event_contact_person',$event->event_contact_person) }}" name="event_contact_person" id="event_contact_person" class="form-control" />
                                        </div>
                                    </div>

                                </div>

                                <!-- Detail Page Image -->
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <strong>Page Header Image
                                                        <span class="text-info">
                                                            Recommended Size: 1920x540 px
                                                        </span>
                                                    </strong>
                                                    <input type="file" class="form-control" name="page_header_image" id="page_header_image" />
                                                </div>
                                            </div>
                                        </div>
                                        @if($page_image && isset($page_image->header))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="{{ asset($page_image->header->path) }}" class="img-thumbnail img-fluid" alt="" />
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <strong>Page Display Image
                                                        <span class="text-info">
                                                            Recommended Size: 670x400 px
                                                        </span>
                                                    </strong>
                                                    <input type="file" class="form-control" name="page_image" id="page_image" />
                                                </div>
                                            </div>
                                        </div>
                                        @if($page_image && isset($page_image->page_image))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="{{ asset($page_image->page_image->path) }}" class="img-thumbnail img-fluid" alt="" />
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Event Location
                                            </strong>
                                            <input value="{{ old('event_location',$event->full_address) }}" type="text" name="event_location" id="event_location" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Event goole map
                                            </strong>
                                            <input type="text" value="{{ old('google_map',$event->google_map_link) }}" name="google_map" id="google_map" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <strong>
                                                Widgets
                                                <sup class="text-danger">
                                                    *
                                                </sup>
                                            </strong>
                                            <select name="widgets[]" id="widgets" multiple class="form-control">
                                                @php
                                                $widgets = \App\Models\Widget::get();
                                                @endphp
                                                @foreach ($widgets as $widget)
                                                <option value="{{ $widget->id }}" @if($widget->events()->where("widgetable_id",$event->id)->exists()) selected @endif>
                                                    {{ $widget->widget_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update Event Info
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js -->
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js" referrerpolicy="origin"> </script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>
@endsection