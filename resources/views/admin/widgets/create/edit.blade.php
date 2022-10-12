@include("admin.widgets.create.accordian.sample")
<form enctype="multipart/form-data" action="{{ route('admin.web.widget.update',[$widget->id]) }}" method="post">
    @csrf
    @method("PUT")
    <div class="row mb-3 pb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="widget_name" class="label-control">Widget Title
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="widget_name" id="widget_name" class="form-control" value="{{ $widget->widget_name }}" />
                @error("widget_name")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="widget_type">Widget Type</label>
                <span class="form-control bg-light">{{ __("widget.".$widget->widget_type) }}</span>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Accordian Layout Setting
                    {{ $widget->layouts->layout }}
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="step" @if($widget->layouts->layout == "step" ) selected @endif>Step</option>
                    <option value="foldable" @if($widget->layouts->layout == "foldable" ) selected @endif>Foldable</option>
                </select>
            </div>
        </div>
    </div>
    @foreach ($widget->fields as $field)
    <div class="row @if($loop->iteration > 1) mt-4 bg-light py-4 @endif">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Accordian Title
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="title[]" value="{{ $field->title }}" class="form-control" />
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
                <textarea name="widget_content[]" id="content" class="form-control">{{ old('widget_content',$field->content) }}</textarea>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row mt-3" id="submit_button">
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary btn-block w-75">
                Update Accordian Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>