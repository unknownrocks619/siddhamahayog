<form enctype="multipart/form-data" action="{{ route('admin.web.widget.store',['widget_name'=>request()->widget_name,'widget_type' => request()->widget_type]) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Image Caption
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="title[]" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Slider Layout
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="step" @if(old('layout')=="step" ) selected @endif>Boxed slider with Controller</option>
                    <option value="foldable" @if(old('layout')=="foldable" ) selected @endif>Open Slider with dots</option>
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

        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="content" class="label-control">Description
                </label>
                <textarea name="widget_content[]" id="content" class="form-control">{{ old('widget_content') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="submit_button">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block w-75">
                Create Slider Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>