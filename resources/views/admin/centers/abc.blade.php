@extends ('layouts/admin')


@section('title')
    I am Mr.
@endSection()

@section('page_css')

<style>
body {
    background: red !important;
}
</style>

@endSection()
@section('content')

    <h1>Hello, I am prajwal. </h1>

@endSection()

@section("page_js")

<script>
    $(document).ready(function(){
        alert("hello mr");
    })
</script>

@endSection();