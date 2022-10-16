<?php
$description = $widget->fields[0]->content;
?>
<div class="row">
    <div class="col-md-6">
        {!! $description !!}
    </div>
    <div class="col-md-6">
        <div class="row">
            @foreach ($widget->fields as $field)
            <div class="col-md-6">
                <img src="{{ asset($field->image->path) }}" alt="{{ $field->title }}" />
            </div>
            @endforeach
        </div>
    </div>

</div>