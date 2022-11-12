@foreach ($widget->fields sa $field)
<div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ asset($field->image->path) }})">
    <div class="container">
        <div class="sigma_subheader-inner">
            <div class="sigma_subheader-text">
                <h1>{{ widget_title($field->title) }}</h1>
            </div>
            <!--  -->
        </div>
    </div>

</div>
@endforeach