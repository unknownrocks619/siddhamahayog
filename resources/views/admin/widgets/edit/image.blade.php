@extends("themes.admin.master")

@section("title")
Edit :: {{ $widget->widget_name }}
@endsection


@push("plugin_css")
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset ('admin/assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">

@endpush


@section("content")
<x-layout heading="Edit :: {{ $widget->widget_name }}">
    <div class="card">
        <div class="card-body">
            <a class="btn btn-sm btn-primary mb-3" href="{{ route('admin.web.widget_by_type',['type'=>$widget->widget_type]) }}">
                <x-arrow-left>Go back</x-arrow-left>
            </a>
            @include("admin.widgets.create.image.sample")
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

                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label for="layout" class="label-control">
                                Layout Setting
                            </label>
                            <select name="layout" id="layout" class="form-control">
                                <option value="background" @if(old('layout', $widget->layouts->layout)=="background" ) selected @endif>Background</option>
                                <option value="right_align_image" @if(old('layout', $widget->layouts->layout)=="foldable" ) selected @endif>Right Align Image</option>
                                <option value="left_align_image" @if(old('layout', $widget->layouts->layout)=="foldable" ) selected @endif>Left Align Image</option>
                                <option value="alternate" @if(old('layout', $widget->layouts->layout)=="foldable" ) selected @endif>Alternate Align Image</option>
                                <option value="single" @if(old('layout', $widget->layouts->layout)=="single" ) selected @endif>Single</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="form-group">
                            <label for="background_color" class="label-control">
                                Background Color
                            </label>
                            <input type="text" id="background_color" class="form-control" name="background_color" value="{{ old('background_color', ($widget->settings && isset($widget->settings->theme_color)) ? $widget->settings->theme_color : null ) }}" />
                        </div>
                    </div>
                </div>
                @foreach ($widget->fields as $field)
                <div class="row @if($loop->iteration > 1) mt-4 bg-light py-4 @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-control">Title
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
                            Update Widget
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
<script src="{{ asset ('admin/assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    tinymce.init({
        selector: 'textarea',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: false,
        toolbar_sticky_offset: isSmallScreen ? 102 : 108,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [{
                title: 'Home Page',
                value: 'https://upschool.co'
            },
            {
                title: 'Contact us',
                value: 'https://upschool.co'
            }
        ],
        image_list: [{
                title: 'My page 1',
                value: 'https://www.tiny.cloud'
            },
            {
                title: 'My page 2',
                value: 'http://www.moxiecode.com'
            }
        ],
        image_class_list: [{
                title: 'None',
                value: ''
            },
            {
                title: 'responsive',
                value: 'img-fluid'
            }
        ],
        importcss_append: true,
        file_picker_callback: elFinderBrowser,

        // file_picker_callback: (callback, value, meta) => {
        //     /* Provide file and text for the link dialog */
        //     if (meta.filetype === 'file') {
        //         callback('https://www.google.com/logos/google.jpg', {
        //             text: 'My text'
        //         });
        //     }

        //     /* Provide image and alt text for the image dialog */
        //     if (meta.filetype === 'image') {
        //         callback('https://www.google.com/logos/google.jpg', {
        //             alt: 'My alt text'
        //         });
        //     }

        //     /* Provide alternative source and posted for the media dialog */
        //     if (meta.filetype === 'media') {
        //         callback('movie.mp4', {
        //             source2: 'alt.ogg',
        //             poster: 'https://www.google.com/logos/google.jpg'
        //         });
        //     }
        // },
        templates: [{
                title: 'New Table',
                description: 'creates a new table',
                content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
            },
            {
                title: 'Starting my story',
                description: 'A cure for writers block',
                content: 'Once upon a time...'
            },
            {
                title: 'New list with dates',
                description: 'New List with dates',
                content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
            }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceEditable',
        images_reuse_filename: true,
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });

    function elFinderBrowser(callback, value, meta) {
        tinymce.activeEditor.windowManager.openUrl({
            title: 'File Manager',
            url: "{{ route('elfinder.tinymce5') }}",
            /**
             * On message will be triggered by the child window
             * 
             * @param dialogApi
             * @param details
             * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
             */
            onMessage: function(dialogApi, details) {
                if (details.mceAction === 'fileSelected') {
                    const file = details.data.file;

                    // Make file info
                    const info = file.name;

                    // Provide file and text for the link dialog
                    if (meta.filetype === 'file') {
                        callback(file.url, {
                            text: info,
                            title: info
                        });
                    }

                    // Provide image and alt text for the image dialog
                    if (meta.filetype === 'image') {
                        callback("{{ config('app.request_protocol') }}" + file.url, {
                            alt: info
                        });
                    }

                    // Provide alternative source and posted for the media dialog
                    if (meta.filetype === 'media') {
                        callback(file.url);
                    }

                    dialogApi.close();
                }
            }
        });
    }
</script>
<script>
    $(function() {
        'use strict';

        $('#background_color').colorpicker();
    });
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