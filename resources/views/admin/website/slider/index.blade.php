@extends("layouts.portal.app")

@section("page_title")
    ::Plugin :: Slider
@endsection

@section("top_css")
<!-- Light Gallery Plugin Css -->
<link rel="stylesheet" href="{{ asset ('assets/plugins/light-gallery/css/lightgallery.css') }}">
@endsection

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Image Gallery</h2>                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                               Slider
                            </strong>
                            Settings
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li>
                                            <a href="{{ route('admin.website.slider.admin_slider_create') }}">
                                                Add New Slider
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.website.menus.admin_settings') }}">
                                                Settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </h2>
                    </div>
                    <div class="body">
                        <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            @foreach ($sliders as $slider)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 m-b-20 border border-primary">
                                    <a href="{{ $slider->slider_file }}">
                                        <img class="img-fluid img-thumbnail" src="{{ $slider->slider_file }}" alt="{{$slider->slider_title}}">
                                    </a>
                                    <h5 class="text-danger">
                                        {{ $slider->slider_title }}
                                    </h5>
                                    @if($slider->tagline)
                                    <blockquote>
                                        {{ $slider->tagline }}
                                    </blockquote>
                                    @endif
                                    @if($slider->description)
                                    {!! $slider->description !!}
                                    @endif
                                    <hr>
                                    <form style="display: inline;" action="{{ route('admin.website.slider.admin_slider_delete',$slider->id) }}" method="post">
                                        @method("DELETE")
                                        @csrf
                                        <button type="submit" onsubmit="return confirm('Are you sure? This action cannot be undone')" class="btn btn-sm btn-danger text-center mx-2">Delete</button>
                                    </form>
                                    <button onclick="window.location='{{ route('admin.website.slider.admin_slider_edit',$slider->id) }}'" type="button" class="btn btn-sm btn-info text-center">Edit</button>
                                </div>
                                
                            @endforeach
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                {{ $sliders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<!-- Light Gallery Plugin Js -->
<script src="{{ asset ('assets/js/pages/medias/image-gallery.js') }}"></script>
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js --> 

<script src="{{ asset ('assets/plugins/light-gallery/js/lightgallery-all.min.js') }}"></script>

@endsection