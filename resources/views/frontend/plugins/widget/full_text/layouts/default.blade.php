@foreach ($widget->fields as $field)
<div class="row">
    <div class="col-md-12">
        <div class="sigma_volunteers volunteers-5">
            <h4 class="title">
                {{ widget_title($field->title) }}
            </h4>
            <div class="m-0 fs-5">
                {!! $field->content !!}
            </div>
        </div>
    </div>
</div>
@endforeach