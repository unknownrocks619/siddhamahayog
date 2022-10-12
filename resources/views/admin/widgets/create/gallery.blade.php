<form enctype="multipart/form-data" action="{{ route('admin.web.widget.store',['widget_name'=>request()->widget_name,'widget_type' => request()->widget_type]) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label-control">Gallery Caption
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="title[]" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="layout" class="label-control">
                    Gallery Layout Setting
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="grid" @if(old('layout')=="grid" ) selected @endif>Grid</option>
                    <option value="column" @if(old('layout')=="column" ) selected @endif>Column</option>
                    <option value="single" @if(old('layout')=="single" ) selected @endif>Single</option>
                    <option value="mac_slider_gallery" @if(old('layout')=="mac_slider_gallery" ) selected @endif>Slider - Mac Book</option>
                    <option value="news_paper_slider_gallery" @if(old('layout')=="news_paper_slider_gallery" ) selected @endif>Slider - Boxed Slider</option>
                    <option value="full_width_slider_gallery" @if(old('layout')=="full_width_slider_gallery" ) selected @endif>Slider - Full Width</option>
                    <option value="banner_cube_gallery" @if(old('layout')=="banner_cube_gallery" ) selected @endif>Slider - Cubic Display</option>
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
                Create Gallery Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">
                <x-plus-file>Add More</x-plus-file>
            </button>
        </div>
    </div>
</form>