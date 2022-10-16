<form enctype="multipart/form-data" action="{{ route('admin.widget.store',['widget_name'=>request()->widget_name,'widget_type' => request()->widget_type]) }}" method="post">
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
                    Layout Setting
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="background" @if(old('layout')=="background" ) selected @endif>Background Video</option>
                    <option value="checkmark_video" @if(old('layout')=="checkmark_video" ) selected @endif>Video With Checkmark</option>
                    <option value="single_video" @if(old('layout')=="single_video" ) selected @endif>Single Video</option>
                    <option value="single_video_pop" @if(old('layout')=="single_video_pop" ) selected @endif>Single Video Modal</option>
                    <option value="two_column" @if(old('layout')=="two_column" ) selected @endif>Two Column Per Row</option>
                    <option value="full_width_video" @if(old('layout')=="full_width_video" ) selected @endif>Full Width Video</option>
                    <option value="single_video_left" @if(old('layout')=="single_video_left" ) selected @endif>Single Video Align Left</option>
                    <option value="single_video_right" @if(old('layout')=="single_video_right" ) selected @endif>Single Video Align Right</option>
                    <option value="single_video_left_pop" @if(old('layout')=="single_video_left_pop" ) selected @endif>Single Video Align Left Modal</option>
                    <option value="single_video_right_pop" @if(old('layout')=="single_video_right_pop" ) selected @endif>Single Video Align Right Modal</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="featured_video" class="label-control">
                    Featured
                </label>
                <select name="featured_video" id="featured_video" class="form-control">
                    <option value="yes" @if(old('featured')=="yes" ) selected @endif>Yes</option>
                    <option value="no" @if(old('featured') !="yes" ) selected @endif>No</option>
                </select>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="image" class="label-control">Poster Image
                </label>
                <input type="file" name="image[]" id="image" class="form-control" />
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="image" class="label-control">Video Url
                    <sup class="text-info">
                        Only Vimeo and Youtube
                    </sup>
                </label>
                <input type="text" name="video_link[]" placeholder="https://youtube.com/watch/?v=sqiu23dg or https://vimeo.com/watch/34234343" class="form-control" />
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
                Create Video Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>