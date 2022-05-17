@extends("layouts.portal.app")

@section("page_title")
    ::Plugin :: Slider
@endsection
@section("page_css")
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Update Slider Detail</h2>                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <x-alert></x-alert>
                @php
                    $plugins_decode = json_decode($slider->plugins);
                @endphp
                <form enctype="multipart/form-data" action="{{ route('admin.website.slider.admin_slider_update',$slider->id) }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Update Slider</strong> Detail
                            </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="{{ route('admin.website.slider.admin_slider_index') }}" class="btn btn-danger btn-sm" >
                                        Close <i class="zmdi zmdi-close"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            Image Title
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="text" value="{{ old('slider_title',$slider->title) }}" name="slider_title" id="slider_title" class="form-control" style="border-radius: 0px;" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Tagline
                                        </strong>
                                        <input value="{{ old('tagline',$slider->tagline) }}" type="text" name="tagline" id="tagline" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Image Description</strong>
                                        <textarea name="image_description" id="image_description" class="form-control">{{ old('image_description',$slider->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Enable Donation
                                        </strong>
                                        <input name="donation_button" value="1" @if($plugins_decode->donation) checked @endif type="checkbox"  data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Join Today
                                        </strong>
                                        <input name="join_today" value="1" @if($plugins_decode->join_now) checked @endif type="checkbox"  data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>
                                            Services Button
                                        </strong>
                                        <input name="services_button" @if($plugins_decode->services) checked @endif value="1" type="checkbox"  data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Active
                                        </strong>
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @if(old('active',$slider->status)) selected @endif>Yes</option>
                                            <option value="0" @if( ! old('acitve', $slider->status)) selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info btn-block">Update Slider image</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                                Selected Image
                            </strong>
                        </h2>
                    </div>
                    <div class="body">
                        <img src='{{$slider->slider_file}}' class="img-fluid" />
                        <br />
                        <h4 class="text-center">
                            {{ $slider->title }}
                        </h4>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.website.slider.admin_slider_delete',$slider->id) }}" method="post">
                                    @method("DELETE")
                                    @csrf
                                    <button type="submit" class="btn btn-block btn-sm btn-danger">Delete Slider</button>
                                </form>
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
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js --> 
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({
            selector : 'textarea',
            toolbar_mode: 'floating'
        })
    });
</script>

@endsection