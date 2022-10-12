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
                    Grid Layout Setting
                </label>
                <select name="layout" id="layout" class="form-control">
                    <option value="col-md-12" @if(old('layout')=="col-md-12" ) selected @endif>1 Column</option>
                    <option value="col-md-6" @if(old('layout')=="col-md-6" ) selected @endif>2 Column</option>
                    <option value="col-md-4" @if(old('layout')=="col-md-4" ) selected @endif>3 Column</option>
                    <option value="col-md-3" @if(old('layout')=="col-md-3" ) selected @endif>4 Column</option>
                    <option value="col-md" @if(old('layout')=="col-md" ) selected @endif>Auto</option>
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
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="image" class="label-control">Icon
                </label>
                <select name="icons[]" class="form-control">
                    <option value="global-icon">Earth</option>
                    <option value="cart-with-arrow-down">Shoping Cart with Downarrow</option>
                    <option value="lightbulb">Bulb</option>
                    <option value="parachute-box">Parachute with box</option>
                    <option value="rocket">Rocket</option>
                    <option value="cubes">Cubes</option>
                </select>
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
                Create Grid Widget
            </button>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
        </div>
    </div>
</form>