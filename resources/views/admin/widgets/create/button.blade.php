<form enctype="multipart/form-data" action="{{ route('admin.web.widget.store',['widget_name'=>request()->widget_name,'widget_type' => request()->widget_type]) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Button Label
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="title[]" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Button Layout
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="btn btn-primary">Primary</option>
                    <option value="btn btn-outline-primary">Outline Primary</option>
                    <option value="btn btn-outline-danger">Outline Danger</option>
                    <option value="btn btn-warning">Warning</option>
                    <option value="btn btn-info">Info</option>
                </select>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="image" class="label-control">Image
                </label>
                <input type="file" name="image[]" id="image" class="form-control" />
            </div>
        </div>

        <div class="col-md-2 mt-3">
            <div class="form-group">
                <div class="form-check form-switch mb-2">
                    <input type="radio" class="form-check-input" id="registration_button" name="button_category" value="registration">
                    <label class="form-check-label" for="registration_button">Registration Button</label>
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-3">
            <div class="form-group">
                <div class="form-check form-switch mb-2">
                    <input type="radio" name="button_category" value="login" class="form-check-input" id="login_button">
                    <label class="form-check-label" for="login_button">Login Button</label>
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-3">
            <div class="form-group">
                <div class="form-check form-switch mb-2">
                    <input type="radio" class="form-check-input" id="auto_auth" name="button_category" value="auto">
                    <label class="form-check-label" for="auto_auth">Auto Login /</label>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="content" class="label-control">Link
                </label>
                <input type="url" class="form-control" name="widget_content[]" value="" />
            </div>
        </div>
    </div>

    <div class="row mt-3" id="submit_button">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block w-75">
                Create Button Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>