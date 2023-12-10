@if( ! session()->has('today-count'))
@php
    // check if user have saved their setting.
    $settings = \App\Models\Yagya\HanumandYagyaCounter::where('member_id',auth()->id())->first();

    if (! $settings ) {
        // load modal to create setting.
        $modalContent = 'hanumand-yagya.partials.settings';
    } else {
        $modalContent = 'hanumand-yagya.partials.daily-counter';
    }
@endphp
    @include($modalContent)
@endif
