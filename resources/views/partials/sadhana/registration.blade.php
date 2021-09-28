@if($request->ajax())
    @if($request->get('input') == "no")
        @include("partials.sadhana.old-registration-email-field")
    @else
        @include("partials.sadhana.new-registration-contd-form")
    @endif
@endif