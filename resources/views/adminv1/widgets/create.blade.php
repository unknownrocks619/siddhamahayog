@extends("layouts.portal.app")

@section("title")
    New Widget Manager
@endsection

@section("plugins_css")
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset ('admin/assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">

@endsection

@section("content")
    <section class="content home">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <h2>New Widget :: {{ ucfirst(request()->widget_type) }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Create</strong> :: <?php echo request()->widget_name ?>
                            </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="{{ route('admin.widget.index') }}" class="btn btn-sm-danger">
                                        <i class="zmdi zmdi-close"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            @include("adminv1.widgets.create.".request()->widget_type.".sample")
                            @include("adminv1.widgets.create.".request()->widget_type)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("page_script")
    <script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script src="{{ asset ('admin/assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
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
    <script>
        $(function () {
            'use strict';

            // $('#background_color').colorpicker();
        });
        $(".add_widget_row").click(function (event) {
            event.preventDefault();
            let content = $("#sample_form").clone();
            let tetId = Math.floor(Math.random() * 57);
            $(content).find('text-area').replaceWith("<textarea id='accord_" + tetId + "' class='form-control' name='widget_content[]'>");
            $(content).insertBefore("#submit_button").fadeIn().removeAttr("id");

            tinymce.init({
                selector: 'textarea#accord_' + tetId,
                plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
                toolbar_mode: 'floating',
            });
        })
        // $(".remove_section").click(function(event) {
        //     event.preventDefault();
        //     console.log("clicked on remove section");
        //     $(this).closest('.row').remove();
        // })
    </script>
@endsection
