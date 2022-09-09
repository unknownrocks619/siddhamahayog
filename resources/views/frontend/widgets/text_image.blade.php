@php
$widget_content = json_decode($widget->widgets);
@endphp

@foreach ($widget_content as $widget_loop)
<hr>
@if ($widget_loop->featured_image)
<div class="row align-items-center">
    <div class="col-lg-5 col-xl-4 mb-lg-30">
        <img src="{{ asset($widget_loop->featured_image->path) }}" class="w-100" alt="details">
    </div>
    <div class="col-lg-7 col-xl-8">
        {!! $widget_loop->content !!}
    </div>
</div>
@else
{!! $widget_loop->content !!}
@endif
@endphp