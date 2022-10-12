@extends("themes.admin.master")

@section("title")
:: Post :: {{ $post->title }}
@endsection

@section("content")
<x-layout heading="Update:: {{ $post->title }}">
    <form action="{{ route('admin.posts.post.update',$post->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method("PUT")
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a class="btn btn-secondary" href="{{ route('admin.posts.post.index') }}">
                            <x-arrow-left>Go Back</x-arrow-left>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="label-control">
                                        Post Title
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" value="{{ old('post_title',$post->title) }}" name="post_title" id="post_title" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="label-control">
                                        Post Short Description
                                    </label>
                                    <textarea class="form-control" name="short_description" id="short_description">{{ old('short_description',$post->short_description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="label-control">
                                        Post Full Description
                                    </label>
                                    <textarea class="form-control" name="full_description" id="full_description">{{ old('full_description',$post->full_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-control">
                                        Post Type
                                    </label>
                                    <select name="post_layout" id="post_layout" class="form-control">
                                        <option value="general" @if(old('post_layout',$post->post_layout) == "general") selected @endif>General / Standard</option>
                                        <option value="gallery" @if(old('post_layout',$post->post_layout) == "gallery") selected @endif>Gallery</option>
                                        <option value="contact" @if(old('post_layout',$post->post_layout) == "contact") selected @endif>contact</option>
                                        <option value="video" @if(old('post_layout',$post->post_layout) == "video") selected @endif>Video</option>
                                        <option value="single-post" @if(old('post_layout',$post->post_layout) == "single-post") selected @endif>Single Post</option>
                                        <option value="posts" @if(old('post_layout',$post->post_layout) == "posts") selected @endif>List Post</option>
                                        <option value="team" @if(old('post_layout',$post->post_layout) == "team") selected @endif>Team</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="label-control">
                                        Display Option
                                    </label>
                                    <select name="post_type" id="post_type" class="form-control">
                                        <option value="public" @if(old('post_type',$post->post_type) == "public") selected @endif>Public</option>
                                        <option value="admin" @if(old('post_type',$post->post_type) == "admin") selected @endif>Admin</option>
                                        <option value="parent" @if(old('post_type',$post->post_type) == "parent") selected @endif>Parent of Student</option>
                                        <option value="auth" @if(old('post_type',$post->post_type) == "auth") selected @endif>Autheticated</option>
                                        <option value="student_plus" @if(old('post_type',$post->post_type) == "student_plus") selected @endif>Student Over 18</option>
                                        <option value="student" @if(old('post_type',$post->post_type) == "student") selected @endif>Student Under 18</option>
                                        <option value="org" @if(old('post_type',$post->post_type) == "org") selected @endif>Organisation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="label-control">
                                        Featured Image
                                    </label>
                                    @if($post->images && isset($post->images->featured_image))
                                    <div>
                                        <img src='{{ asset($post->images->featured_image->path) }}' class="img-fluid" />
                                        <a href="{{ route('admin.posts.destroy_media',$post->id) }}" data-slug="featured_image" data-type='image' class="border border-danger btn btn-outline-danger m-2 media_destroy">
                                            <x-trash>Remove Featured Image</x-trash>
                                        </a>
                                    </div>
                                    @endif
                                    <input type="file" name="featured_image" id="featured_image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <strong>
                                        Featured Video URL
                                    </strong>
                                    <?php
                                    $featured_video = ($post->videos && isset($post->videos->featured_video)) ? $post->videos->featured_video->link : null;
                                    $banner_video  = ($post->videos && isset($post->videos->banner_video)) ? $post->videos->banner_video->link : null;
                                    ?>
                                    <input type="url" value="{{ old('featured_video',$featured_video) }}" name="featured_video" id="featured_video" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <strong>
                                        Banner Video URL
                                    </strong>

                                    <input type="url" value="{{ old('banner_video',$banner_video) }}" name="banner_video" id="featured_video" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="label-control">
                                        Banner Image
                                    </label>
                                    @if($post->images && isset($post->images->banner_image) )
                                    <div id="image">
                                        <img src='{{ asset($post->images->banner_image->path) }}' class="img-fluid" />
                                        <a href="{{ route('admin.posts.destroy_media',$post->id) }}" data-slug="banner_image" data-type="image" class="border border-danger btn btn-outline-danger m-2 media_destroy">
                                            <x-trash>Remove Banner Image</x-trash>
                                        </a>
                                    </div>
                                    @endif
                                    <input type="file" name="banner_image" id="banner_image" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            Update Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>
@endsection

@push("custom_script")
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
                title: 'Some class',
                value: 'class-name'
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
        noneditable_class: 'mceNonEditable',
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
<script type="text/javascript">
    $(document).on('click', '.media_destroy', function(event) {
        event.preventDefault();
        var el = $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data: "slug=" + $(this).data("slug") + "&type=" + $(this).data('type'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success == true) {
                    $(el).closest("div").fadeOut("fast");
                }
            }
        })
    })
</script>
@endpush