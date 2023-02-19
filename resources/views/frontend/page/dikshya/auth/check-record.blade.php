<?php
$userRelation = user()->meta;
$dikshay = user()->diskshya;
$userMeta = user()->emergency;
$formPart = [];
$form_action = 'three';
// check if this user have already taken diskhya form
?>

@if (!$dikshay->count())
    @php
        $formPart['diskha'] = 'diskhshya-form';
        $form_action = 'two';
    @endphp
@endif




@if (!$userMeta->contact_person || !$userMeta->relation || !$userMeta->phone_number)
    @php
        
        $formPart['meta'] = 'emergency-contact-information';
        $form_action = 'two';
    @endphp
@endif

@if (!$userRelation->history || !$userRelation->personal || !$userRelation->education)
    @php
        $formPart['relation'] = 'reference';
        $form_action = 'two';
    @endphp
@endif

@if (
    !isset($formPart['relation']) &&
        (!$userRelation->history->medicine_history ||
            !$userRelation->history->mental_health_history ||
            !$userRelation->personal->date_of_birth ||
            !$userRelation->personal->place_of_birth))
    @php
        $form_action = 'two';
        $formPart['medicine-history'] = 'reference';
    @endphp
@endif


@if (
    !isset($formPart['relation']) &&
        !isset($formPart['diksha']) &&
        $dikshay->count() &&
        !isset($formPart['medicine-history']))
    @php
        $diksha = user()
            ->diskshya()
            ->latest()
            ->first();
        if ($diksha->remarks == null || (isset($diksha->remarks->terms) && $diksha->remarks->terms != true)) {
            $formPart['diskha'] = 'terms';
            $form_action = 'three';
        }
    @endphp
@endif

<form action="{{ route('dikshya.store', $form_action) }}" method="post">
    @csrf
    @if (isset($formPart['medicine-history']))
        @include('frontend.page.dikshya.parts.medicine-history')
        @include('frontend.page.dikshya.parts.button', ['label' => 'Next'])
    @elseif(!empty($formPart))
        @foreach ($formPart as $includeForm)
            <div class="row mb-2">
                <div class="col-md-12">
                    @include('frontend.page.dikshya.parts.' . $includeForm)
                </div>
            </div>
        @endforeach
        @include('frontend.page.dikshya.parts.button', ['label' => 'Next'])
    @endif
    @if (empty($formPart))
        @include('frontend.page.dikshya.parts.complete')
        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-lg btn-pink-moon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                        style="fill: rgba(255, 255, 95, 1);transform: ;msFilter:;">
                        <path
                            d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z">
                        </path>
                    </svg>
                    Visit Dashboard
                </a>
            </div>
        </div>
    @endif
</form>
