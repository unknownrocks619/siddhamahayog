<div class="row">
    @foreach ($widget->fields as $field)
    <div class="{{ $widget->layouts->layout }}">
        <a href="{{ asset($field->image->path) }}" class="gallery-thumb" title="{{ $field->title }}">
            <img src="{{ asset($field->image->path) }}" alt="{{ $field->title }}">
        </a>
    </div>
    @endforeach
</div>