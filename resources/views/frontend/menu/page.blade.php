@extends("frontend.theme.master")
@section("content")

<?php
$pages = $menu->load(['pages' => function ($query) {
    return $query->with('widget');
}])->pages;

?>

<x-banner style="background-image: url({{ asset('assets/images/program/sadhana/heading-banner.jpg') }})">
</x-banner>


<!-- partial -->
<div class="section section-padding" style="padding-top:50px">
    <div class="container">

        @foreach($pages as $page)
        @foreach ($page->widget as $widget)
        @include("frontend.plugins.widget.".$widget->widget_type.".layouts.".$widget->layouts->layout , compact("widget"))
        <div class="row my-3">
            <div class="col-md-12"><a href="{{ route('vedanta.create') }}" class="btn py-2 w-100 btn-outline-primary">Register for Vedanta Philosophy Arthapanchaka Program</a></div>
        </div>
        @endforeach

        @endforeach

    </div>
</div>
@endsection