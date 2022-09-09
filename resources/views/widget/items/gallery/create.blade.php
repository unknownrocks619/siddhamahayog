<div class="row mt-3 " id="sample_form" style="display:none">
    <div class="col-md-12">
        <div class="form-group">
            <strong>
                Image Caption
            </strong>
            <input type="text" name="image_caption[]" class="form-control" />
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <strong>
                Image
            </strong>
            <input type="file" name="text_file[]" class="form-control" />
        </div>
    </div>
</div>
<form method="POST" id="accordian_form_element" enctype="multipart/form-data" action="{{ route('widget.slider.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Widget Name
                    <sup class="text-danger">*</sup>
                </strong>
                <input type="text" name="widget_name" id="button_name" class="form-control" />
            </div>
        </div>
        <div class="col-md-3">
            <a href="#" class="add_accordian_content btn btn-primary"><i class='zmdi zmdi-plus'></i>Add Image(s)</a>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="form-group">
                <strong>
                    Image Caption
                </strong>
                <input type="text" name="image_caption[]" id="text_title" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Image
                </strong>
                <input type="file" name="text_file[]" class="form-control" />
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
    $(".add_accordian_content").click(function(event){
        let content = $("#sample_form").clone();
        // let tetId = Math.floor(Math.random() * 57);
        // $(content).find('text-area').replaceWith("<textarea id='accord_"+tetId+"' class='form-control' name='text_content[]'>");
        $(content).insertBefore("#submit_button").fadeIn().removeAttr("id");
    })
</script>