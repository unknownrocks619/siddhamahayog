@php
    $widget_content = json_decode($widget->widgets);
@endphp

@foreach ($widget_content as $widget_loop)

<hr>
<h4>{{ $widget_loop->title }}</h4>
<div class="row align-items-center">
    <div class="col-lg-6">
        {!! $widget_loop->content !!}
    </div>
    <div class="col-lg-6">
        <div class="event-venue-map">
            <iframe src="{{ \Str::between($widget_loop->map,'src="','"') }}" style="border:0; width: 100%; height: 200px;" allowfullscreen></iframe>
        </div>
    </div>
</div>
@endforeach