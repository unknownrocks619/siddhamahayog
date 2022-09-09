@extends("layouts.portal.app")

@section("title")
Widgets
@endsection

@section("css")
@endsection

@section("content")
<!-- Main Content -->
<section class="content home">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Create New </strong> Widget
                        </h2>
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Widget Name
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="text" name="widget_name" id="widget_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Widget Type
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <select name="widget_type" id="widget_type" class="form-control">
                                        <option value="text_image">Text / Image</option>
                                        <option value="text_video">Text / Video</option>
                                        <option value="slider">Slider</option>
                                        <option value="accordian">Accordian</option>
                                        <option value='banner_image_text'>Banner Image / Text</option>
                                        <option value='faq'>FAQ</option>
                                        <option value="banner_video">Banner Video</option>
                                        <option value='banner_video_checkmark'>Banner Video Checkmark</option>
                                        <option value='pdf_reader'>PDF Reader</option>
                                        <option value="buttons" data-load="{{ route('widget.button.create') }}">Button</option>
                                        <option value="gallery">Gallery</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="widget_load"></div>
    </div>
</section>
@endsection

@section("script")
<script src="{{ asset ('admin/assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript">
    $("#widget_type").change(function(event) {
        event.preventDefault();

        let widget_type = $(this).val();
        let widget_url = $(this).attr("data-url");
        $.ajax({
            type: "GET",
            url: widget_url,
            success: function(success) {
                $("#widget_load").addClass("mt-2 border border-top").html(success);
            }
        })
    })
</script>
@endsection