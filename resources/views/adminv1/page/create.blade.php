@extends("layouts.portal.app")

@section("title")
New Page
@endsection

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">

        </div>
        <div class="row">
            <div class="col-md-12">
                <x-alert></x-alert>
                <form action="{{ route('admin.page.page.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>New</strong> Page
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <a class="btn btn-secondary" href="{{ route('admin.page.page.index') }}">
                                        <x-arrow-left>Go Back</x-arrow-left>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Title
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="text" value="{{ old('page_name') }}" name="page_name" id="page_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Page Description
                                                </label>
                                                <textarea class="form-control" name="page_description" id="page_description">{{ old('page_description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Page Type
                                                </label>
                                                <select name="page_type" id="page_type" class="form-control">
                                                    <option value="terms" @if(old('page_type')=='terms' ) selected @endif>Terms & Condition</option>
                                                    <option value="standard" @if(old('page_type')=='standard' ) selected @endif>Standard</option>
                                                    <option value="gallery" @if(old('page_type')=='gallery' ) selected @endif>Gallery</option>
                                                    <option value="about-us" @if(old('page_type')=='about-us' ) selected @endif>About Us</option>
                                                    <option value="contact-us" @if(old('page_type')=='contact-us' ) selected @endif>Contact Us</option>
                                                    <option value="team" @if(old('page_type')=='team' ) selected @endif>Team</option>
                                                    <option value="project-single" @if(old('page_type')=='project-single' ) selected @endif>Project Single</option>
                                                    <option value="course" @if(old('page_type')=='courses' ) selected @endif>Course</option>
                                                    <option value="video" @if(old('page_type')=='video' ) selected @endif>Video</option>
                                                    <option value="home" @if(old('page_type')=='home' ) selected @endif>Home</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Display Option
                                                </label>
                                                <select name="display_option" id="display_option" class="form-control">
                                                    <option value="public" @if(old('display_option')=='public' ) selected @endif>Public</option>
                                                    <option value="admin" @if(old('display_option')=='admin' ) selected @endif>Admin</option>
                                                    <option value="staff" @if(old('display_option')=='staff' ) selected @endif>Staff</option>
                                                    <option value="auth" @if(old('display_option')=='auth' ) selected @endif>Autheticated</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Featured Image
                                                </label>
                                                <input type="file" name="featured_image" id="featured_image" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="label-control">
                                                    Banner Image
                                                </label>
                                                <input type="file" name="banner_image" id="featured_image" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        Create Page
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
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
</script>
@endsection