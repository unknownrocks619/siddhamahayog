@extends("themes.admin.master")

@section("title")
Edit :: {{ $widget->widget_name }}
@endsection

@section("content")
<x-layout heading="Edit :: {{ $widget->widget_name }}">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.web.widget_by_type',$widget->widget_type) }}">
                Go back
            </a>
            @include("admin.widgets.create.banner_text.sample")
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
                                <option value="default" @if(old('layout')=="default" ) selected @endif>Theme Default</option>
                                <option value="background" @if(old('layout')=="background" ) selected @endif>Background</option>
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
                            Update Banner Widget
                        </button>
                    </div>

                    <div class="col-md-4">
                        <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
@endsection

@push("custom_script")
<script>
    $(".add_widget_row").click(function(event) {
        event.preventDefault();
        let content = $("#sample_form").clone();
        let tetId = Math.floor(Math.random() * 57);
        $(content).find('text-area').replaceWith("<textarea id='accord_" + tetId + "' class='form-control' name='widget_content[]'>");
        $(content).insertBefore("#submit_button").fadeIn().removeAttr("id");

        // tinymce.init({
        //     selector: 'textarea#accord_' + tetId,
        //     plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        //     toolbar_mode: 'floating',
        // });
    })
    // $(".remove_section").click(function(event) {
    //     event.preventDefault();
    //     console.log("clicked on remove section");
    //     $(this).closest('.row').remove();
    // })
</script>
@endpush