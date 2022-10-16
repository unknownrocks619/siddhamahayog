@foreach ($widget->fields as $widget_field)
<?php
$title = widget_title($widget_field->title);
$image =  (isset($widget_field->image) && isset($widget_field->image->path)) ?  asset($widget_field->image->path) : $widget_field->video->thumbnail;
$content = $widget_field->content;
$video_type = $widget_field->video->source;
$video_id = $widget_field->video->id;
$link = $widget_field->video->link;
?>
<div class="row sigma_broadcast-video">
    <div class="col-12 mb-5">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6">
                <div class="sigma_video-popup-wrap">
                    <img src="{{ $image }}" alt="{{ $title }}">
                    <a href="{{ $link }}" class="sigma_video-popup popup-youtube">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sigma_box m-0">
                    <h4 class="title">{{ $title }}</h4>
                    <div class="m-0 fs-5">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach