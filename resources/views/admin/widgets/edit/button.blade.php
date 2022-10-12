@extends("themes.admin.master")

@section("title")
Edit :: {{ $widget->widget_name }}
@endsection

@section("content")
<x-layout heading="Edit :: {{ $widget->widget_name }}">
    <div class="card">
        <div class="card-body">
            <a class="btn btn-sm btn-primary mb-3" href="{{ route('admin.web.widget_by_type',['type'=>$widget->widget_type]) }}">
                <x-arrow-left>Go back</x-arrow-left>
            </a>
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
                                <option value="btn btn-primary" @if($widget->layouts->layout == 'btn btn-primary') selected @endif>Primary</option>
                                <option value="btn btn-outline-primary" @if($widget->layouts->layout == 'btn btn-outline-primary') selected @endif>Outline Primary</option>
                                <option value="btn btn-outline-danger" @if($widget->layouts->layout == 'btn btn-outline-danger') selected @endif>Outline Danger</option>
                                <option value="btn btn-warning" @if($widget->layouts->layout == 'btn btn-warning') selected @endif>Warning</option>
                                <option value="btn btn-info" @if($widget->layouts->layout == 'btn btn-info') selected @endif>Info</option>
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



                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image" class="label-control">Image
                            </label>
                            <input type="file" name="image[]" id="image" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <div class="form-check form-switch mb-2">
                                <input type="radio" @if($field->button_action == "registration") checked @endif class="form-check-input" id="registration_button" name="button_category" value="registration">
                                <label class="form-check-label" for="registration_button">Registration Button</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <div class="form-check form-switch mb-2">
                                <input type="radio" @if($field->button_action == "login") checked @endif name="button_category" value="login" class="form-check-input" id="login_button">
                                <label class="form-check-label" for="login_button">Login Button</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <div class="form-check form-switch mb-2">
                                <input type="radio" @if($field->button_action == "auto") checked @endif class="form-check-input" id="auto_auth" name="button_category" value="auto">
                                <label class="form-check-label" for="auto_auth">Auto Login / Registration</label>
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
                @endforeach
                <div class="row mt-3" id="submit_button">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary btn-block w-75">
                            Update Accordian Widget
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-layout>
@endsection