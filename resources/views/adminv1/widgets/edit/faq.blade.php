@extends("layouts.portal.app")

@section("title")
    Edit :: {{ $widget->widget_name }}
@endsection

@section("content")
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="block-header"></div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Strong :: {{ $widget->widget_name }}
                            </h2>
                        </div>
                        <div class="body">
                            <a class="btn btn-sm btn-primary mb-3"
                               href="{{ route('admin.widget.widget_by_type',['type'=>$widget->widget_type]) }}">
                                <x-arrow-left>Go back</x-arrow-left>
                            </a>
                            @include("adminv1.widgets.create.faq.sample")
                            <form enctype="multipart/form-data"
                                  action="{{ route('admin.widget.update',[$widget->id]) }}" method="post">
                                @csrf
                                @method("PUT")
                                <div class="row mb-3 pb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="widget_name" class="label-control">Widget Title
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="widget_name" id="widget_name" class="form-control"
                                                   value="{{ $widget->widget_name }}"/>
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
                                                <option value="full_faq"
                                                        @if(old('layout', $widget->layouts->layout)=="full_faq" ) selected @endif>
                                                    Full Column FAQ
                                                </option>
                                                <option value="with_image"
                                                        @if(old('layout', $widget->layouts->layout)=="with_image" ) selected @endif>
                                                    Side Image Faq
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($widget->fields as $field)
                                    <div class="row @if($loop->iteration > 1) mt-4 bg-light py-4 @endif">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label-control">FAQ Heading
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="text" name="title[]" value="{{ $field->title }}"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="form-group">
                                                <label for="image" class="label-control">Image
                                                </label>
                                                <input type="file" name="image[]" id="image" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label for="content" class="label-control">Content
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <textarea name="widget_content[]" id="content"
                                                          class="form-control">{{ $field->content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row mt-3" id="submit_button">
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-block w-75">
                                            Update FAQ Widget
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-secondary add_widget_row">Add More</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>

    <script>
        $(".add_widget_row").click(function (event) {
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
@endsection
