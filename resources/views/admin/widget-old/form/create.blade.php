@extends("layouts.portal.app")

@section("page_title")
Add Widgets
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
                            <ul class="header-dropdown">
                                <li>
                                    <a href="{{ route('admin.widget.index') }}" class="btn btn-sm btn-info">
                                        <i class="zmdi zmdi-close"></i> Close </a>
                                </li>
                            </ul>
                        </h2>
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <strong>
                                        Widget Type
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <select name="widget_type" id="widget_type" class="form-control">
                                        <option value="text_image" data-load="{{ route('widget.text.create') }}">Text</option>
                                        <option value="text_map" data-load="{{ route('widget.text_map.create') }}">Text Map</option>
                                        <option value="text_image" data-load="{{ route('widget.text_image.create') }}">Text / Image</option>
                                        <option value="text_video" data-load="{{ route('widget.text_video.create') }}">Text / Video</option>
                                        <option value="slider" data-load="{{ route('widget.slider.create') }}">Slider</option>
                                        <option value="accordian" data-load="{{ route('widget.accordian.create') }}">Accordian</option>
                                        <option value='banner_image_text' data-load="{{ route('widget.banner_image.create') }}">Banner Image / Text</option>
                                        <option value='faq' data-load="{{ route('widget.faq.create') }}">FAQ</option>
                                        <option value="banner_video" data-load="{{ route('widget.banner_video.create') }}">Banner Video</option>
                                        <option value='banner_video_checkmark'>Banner Video Checkmark</option>
                                        <option value='pdf_reader' data-load="{{ route('widget.PDF.create') }}">PDF Reader</option>
                                        <option value="buttons" data-load="{{ route('widget.button.create') }}">Button</option>
                                        <option value="gallery" data-load="{{ route('widget.gallery.create') }}">Gallery</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="body" id="widget_load">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let default_selected_widget = $("#widget_type").find(":selected").attr("data-load");
        $.ajax({
            type: "GET",
            url: default_selected_widget,
            success: function(response) {
                $("#widget_load").addClass("mt-2 border border-top").html(response);
                tinymce.init({
                    selector: 'textarea',
                    plugins: 'advlist media autolink lists link image charmap preview anchor pagebreak,lists ',
                    toolbar_mode: 'floating',
                    toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                        'alignleft aligncenter alignright alignjustify | numlist bullist' +
                        'bullist numlist outdent indent | removeformat | a11ycheck code table help'
                });
            }
        })
    })
    $("#widget_type").change(function(event) {
        event.preventDefault();

        let widget_type = $(this).val();
        let widget_url = $(this).find(":selected").attr("data-load");
        console.log(widget_url);
        $.ajax({
            type: "GET",
            url: widget_url,
            success: function(success) {
                $("#widget_load").addClass("mt-2 border border-top").html(success);
                tinymce.init({
                    selector: 'textarea',
                    plugins: 'advlist media autolink lists link image charmap preview anchor pagebreak,lists ',
                    toolbar_mode: 'floating',
                    toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                        'alignleft aligncenter alignright alignjustify | numlist bullist' +
                        'bullist numlist outdent indent | removeformat | a11ycheck code table help'
                });
            }
        })
    })
</script>
@endsection