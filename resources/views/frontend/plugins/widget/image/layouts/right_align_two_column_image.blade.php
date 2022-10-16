<?php
$content = 0;
$description = $widget->fields[$content]->content;
?>
<div class="row align-items-center">
    <div class="col-lg-6 mb-lg-30">
        <div class="blockquote bg-transparent fs-5">
            {!! $description !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="me-lg-30">
            <div class="row">
                @foreach ($widget->fields as $field)
                <div class="col-lg-6 col-md-6">
                    <div class="sigma_volunteers volunteers-5">
                        <div class="sigma_volunteers-thumb">
                            <img src="{{ asset($field->image->path) }}" alt="{{ $field->title }}" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>