<?php
$title = widget_title($widget->fields->title);
$image = isset($widget->fields->image) ? $widget->fields->video->thumbnail : asset($widget->fields->path);
$content = $widget->fields->content;
$video_type = $widget->fields->video->source;
$video_id = $widget->fields->video->id;
$link = $widget->fields->video->link;
?>
<div class="row sigma_broadcast-video">
    <div class="col-12 mb-5">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6">
                <div class="sigma_box m-0">
                    <h4 class="title">{{ $title }}</h4>
                    <div class="m-0 fs-5">
                        {!! $content !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sigma_video-popup-wrap">
                    <img src="{{ $image }}" alt="{{ $title }}">
                    <a href="{{ $link }}" class="sigma_video-popup popup-youtube">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>