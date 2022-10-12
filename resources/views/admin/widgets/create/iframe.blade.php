<form enctype="multipart/form-data" action="{{ route('admin.web.widget.store',['widget_name'=>request()->widget_name,'widget_type' => request()->widget_type]) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Title
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="title[]" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Layout
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="default">Default</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="content" class="label-control">IFRAME CODE
                    <sup class="text-warning">
                        Paste your Iframe Code Here
                    </sup>
                </label>
                <textarea name="widget_content[]" id="widget_content" class="form-control">{{old('widget_content.0')}}</textarea>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="submit_button">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block w-75">
                Create Iframe Widget
            </button>
        </div>
    </div>
</form>