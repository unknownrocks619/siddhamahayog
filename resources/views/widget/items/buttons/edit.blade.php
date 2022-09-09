<form method="POST" enctype="multipart/form-data" action="{{ route('widget.button.update',$widget->id) }}">
    @method("PUT")
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Button Name
                    <sup class="text-danger">*</sup>
                </strong>
                <input type="text" name="button_name" value="{{ old('button_name',$widget->widget_name) }}" id="button_name" class="form-control" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Button Type
                </strong>
                <select name="button_type" id="button_type" class="form-control">
                    <option value="select value">Select Button Type </button>
                    <option value="external_link">External Link</option>
                    <option value="force_download">Force Download</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row mt-2" id="force_download_options" style="display:none">
        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Download File
                </strong>
                <input type="file" name="download_file[]" id="download_file" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>
                    Button Label
                    <sup class="text-danger">*</sup>
                </strong>
                <input type="text" name="download_button_label[]" id="button_label" class="form-control" />
            </div>
        </div>
    </div>
    <div class="row mt-2" id="external_url" style="display:none">
        <div class="col-md-8">
            <div class="form-group">
                <strong>
                    External Url
                </strong>
                <input type="url" name="external_url[]" id="external_url" class="form-control" />
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-g">
                <div class="form-group">
                    <strong>
                        Button Label
                    </strong>
                    <input type="text" name="button_label[]" id="button_label" class="form-control" />
                </div>
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
    $("#button_type").change(function() {
        if ($(this).find("option").length == 3) {
            $(this).find("option").first().remove();
        }
        if ($(this).val() == "external_link") {
            $("#external_url").fadeIn()
            $("#force_download_options").fadeOut();

        } else if ($(this).val() == "force_download") {
            $("#force_download_options").fadeIn();
            $("#external_url").fadeOut()
        }
    })
</script>