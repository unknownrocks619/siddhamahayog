@extends('layouts.admin')

@section('page_css')

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ $user_detail->full_name() }} 
                        <span id='pet_name_container'>
                        @if($user_detail->pet_name)
                            ( {{ $user_detail->pet_name }} )
                        @endif
                        </span>
                    </h4>
                </div>
                @include("admin.users.sadhak-entry.partials.navigation")
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-6">
            <div class="card">
                <div class='card-header'>
                    <h4 class='card-title'>{{ __("sadhak_registration.do_you_have_any_physical_difficulties") }}</h4>
                </div>
                <div class='card-body'>
                    <p class='card-text' style="font-size:24px">
                        @if($user_mental_queries->have_physical_difficulties)
                            {{ __('sadhak_registration.yes') }}
                        @else
                            {{ __('sadhak_registration.no') }}
                        @endif
                    </p>
                    @if($user_mental_queries->have_physical_difficulties)
                        <h4 class="card-title">{{ __("Physical Difficulties") }}</h4>
                        <p class='card-text ' style="font-size:24px">
                            {{ $user_mental_queries->describe_physical_difficulties }}
                        </p>
                    @endif
                </div>
                <!-- Card flex-->
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class='card-header'>
                    <h4 class='card-title'>{{ __("sadhak_registration.do_you_have_any_mental") }}</h4>
                </div>    
                <div class='card-body'> 
                    <p class='card-text ' style="font-size:24px">
                        @if($user_mental_queries->have_metal_problem)
                            {{ __('sadhak_registration.yes') }}
                        @else
                            {{ __('sadhak_registration.no') }}
                        @endif
                    </p>
                    @if($user_mental_queries->have_metal_problem)
                        <h4 class="card-title">{{ __("Mental Difficulties") }}</h4>
                        <p class='card-text ' style="font-size:24px">
                            {{ $user_mental_queries->describe_mental_difficulties }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endSection()
