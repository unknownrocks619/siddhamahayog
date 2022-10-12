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

        <div class="col-md-4">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Layout Setting
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="background" @if(old('layout')=="background" ) selected @endif>Background</option>
                    <option value="right_align_image" @if(old('layout')=="right_align_image" ) selected @endif>Right Align Image</option>
                    <option value="left_align_image" @if(old('layout')=="left_align_image" ) selected @endif>Left Align Image</option>
                    <option value="alternate" @if(old('layout')=="alternate" ) selected @endif>Alternate Align Image</option>
                    <option value="single" @if(old('layout')=="single" ) selected @endif>Single Image</option>

                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="background_color" class="label-control">
                    Background Color
                </label>
                <input type="text" id="background_color" class="form-control" name="background_color" value="{{ old('background_color') }}" />
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
                <label for="content" class="label-control">Content
                    <sup class="text-danger">*</sup>
                </label>
                <textarea name="widget_content[]" id="content" class="form-control">{{ old('widget_content') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="submit_button">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block w-75">
                Create Image Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>