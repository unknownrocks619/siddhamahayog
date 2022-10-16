<div class="row">
    @foreach ($widget->fields as $field)
    @if($loop->iteration % 2 )
    <div class="col-md-6">
        <img src="{{ asset($field->image->path) }}" />
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                {!! $field->description !!}
            </div>
        </div>
    </div>
    @else
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                {!! $field->description !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <img src="{{ asset($field->image->path) }}" />
    </div>

    @endif
    @endforeach

</div>