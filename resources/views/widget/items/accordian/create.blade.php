<div class="row mt-2 border" id="sample_form" style="display:none">
    <div class="col-md-12">
        <div class="form-group">
            <strong>
                Accordian Title
            </strong>
            <input type="text" name="accordian_title[]" id="accordian_title" class="form-control" />
        </div>
    </div>

    <div class="col-md-6">
        <strong>Featured Image</strong>
        <input type="file" name="accordian_featured_image[]" id="accordian_featured_image" class="form-control" />
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <strong>
                Accordian Content
                <sup class="text-danger">*</sup>
            </strong>
            <text-area name="accordian_content[]" class="form-control"></text-area>
        </div>
    </div>
</div>
<form method="POST" id="accordian_form_element" enctype="multipart/form-data" action="{{ route('widget.accordian.store') }}">
    @csrf

    <div class="row bg-light">

        <div class="col-md-4">
            <div class="row bg-light">
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>
                            Widget Name
                            <sup class="text-danger">*</sup>
                        </strong>
                        <input type="text" name="widget_name" id="button_name" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>
                            Widget Title
                            <sup class="text-danger">*</sup>
                        </strong>
                        <input type="text" name="widget_title" id="button_name" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 border mb-3  py-2">
                    <div class="form-group">
                        <strong>Front Image</strong>
                        <input type="file" name="front_image" id="front_image" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 border mb-3  py-2">
                    <div class="form-group">
                        <strong>Top Back Image</strong>
                        <input type="file" name="top_back_image" id="top_back_image" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 border py-2">
                    <div class="form-group">
                        <strong>Bottom Back Image</strong>
                        <input type="file" name="bottom_back_image" class="form-control" id="bottom_back_image" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <strong>Widget Description / Content</strong>
                <textarea name="widget_content_description" class="form-control" id="widget_content_description"></textarea>
            </div>
        </div>
    </div>

    <div class="row bg-light mb-4">
        <div class="col-md-12 mb-3">
            <a href="#" class="btn btn-info w-100 add_accordian_content">
                <i class='zmdi zmdi-plus'></i>Add Accordian</a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group">
                <strong>
                    Accordian Title
                </strong>
                <input type="text" name="accordian_title[]" id="accordian_title" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <strong>Featured Image</strong>
            <input type="file" name="accordian_featured_image[]" id="accordian_featured_image" class="form-control" />
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <strong>
                    Accordian Content
                    <sup class="text-danger">*</sup>
                </strong>
                <textarea name="accordian_content[]" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="submit_button">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Create Widget</button>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(".add_accordian_content").click(function(event) {
        event.preventDefault();
        let content = $("#sample_form").clone();
        let tetId = Math.floor(Math.random() * 57);
        $(content).find('text-area').replaceWith("<textarea id='accord_" + tetId + "' class='form-control' name='accordian_content[]'>");
        $(content).insertBefore("#submit_button").fadeIn().removeAttr("id");

        tinymce.init({
            selector: 'textarea#accord_' + tetId,
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
        });
    })
</script>