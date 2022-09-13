@extends("layouts.portal.app")

@section("page_title")
Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Menus</h2>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
        <form action="{{ route('admin.website.menus.admin_store_menu') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i>
                                &nbsp;
                                Save Menu
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Add New </strong> Menu
                                <ul class="header-dropdown">
                                    <li class="dropdown">
                                        <a href="{{ route('admin.website.menus.admin_menu_list') }}" class="btn btn-sm btn-danger">
                                            Close <i class="zmdi zmdi-close"></i>
                                        </a>
                                    </li>
                                </ul>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <strong>
                                                    Menu Name
                                                    <sup class="text-danger">*</sup>
                                                </strong>
                                                <input value="{{ old('menu_name') }}" type="text" name="menu_name" id="menu_name" style="border-radius:0px;" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <strong>
                                                    Slug
                                                    <sup class="text-danger">*</sup>
                                                </strong>
                                                <input type="text" name="slug" id="slug" placeholder="[Auto-Generate]" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <strong>Describe Menu
                                                <sup class="text-danger">*</sup>
                                            </strong>
                                            <textarea name="menu_description" id="menu_description" class="form-control">{{ old('menu_description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>
                                                    Menu Type
                                                    <sup class="text-danger">
                                                        *
                                                    </sup>
                                                </strong>
                                                <select name="menu_type" id="menu_type" class="form-control">
                                                    <option value="home" @if(old('menu_type')=="home" ) selected @endif>Home page</option>
                                                    <option value="gallery" @if(old('menu_type')=="gallery" ) selected @endif>Gallery</option>
                                                    <option value="about" @if(old('menu_type')=="about" ) selected @endif>About Us</option>
                                                    <option value="contact" @if(old('menu_type')=="contact" ) selected @endif>Contact Us</option>
                                                    <option value="events" @if(old('menu_type')=="events" ) selected @endif>Events List</option>
                                                    <option value="program" @if(old('menu_type')=="program" ) selected @endif>Program</option>
                                                    <option value="products" @if(old('menu_type')=="products" ) selected @endif>Products List</option>
                                                    <option value="service" @if(old('menu_type')=="service" ) selected @endif>Service</option>
                                                    <option value="blog" @if(old('menu_type')=="blog" ) selected @endif>Blog</option>
                                                    <option value="dontaion" @if(old('menu_type')=="donation" ) selected @endif>Donation Page</option>
                                                    <option value="live" @if(old('menu_type')=="live" ) selected @endif>Live Boarcast</option>
                                                    <option value="volunteer" @if(old('menu_type')=="volunteer" ) selected @endif>Volunteer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>
                                                    Active Status
                                                    <sup class="text-danger">
                                                        *
                                                    </sup>
                                                </strong>
                                                <select name="active_status" id="active_status" class="form-control">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>
                                                    Select Featured Image
                                                </strong>
                                                <input type="file" name="featured_image" id="featured_image" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- sidebar -->
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>
                                                Display
                                                <sup class="text-danger">*</sup>
                                            </strong>
                                            <select name="display" id="display_type" class="form-control">
                                                <option value="public" @if(old('display_type')=="public" ) selected @endif>Public</option>
                                                <option value="draft" @if(old('menu_type')=="draft" ) selected @endif>Draft</option>
                                                <option value="private" @if(old('menu_type')=="private" ) selected @endif>Private</option>
                                                <option value="protected" @if(old('menu_type')=="protected" ) selected @endif>Protected</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <strong>Menu Position</strong>
                                                <select name="menu_position" id="menu_poistion" class="form-control">
                                                    <option value="top" @if(old('menu_position')=="top" ) selected @endif>Top Menu</option>
                                                    <option value="main_menu" @if(old('menu_position')=="main_menu" ) selected @endif>Main Menu</option>
                                                    <option value="footer" @if(old('menu_position')=="footer" ) selected @endif>Footer Menu</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <strong>
                                                    Parent Menu
                                                </strong>
                                                <select name="parent_menu" id="parent_menu" class="form-control">
                                                    <option value="0">No Parent Menu</option>
                                                    @foreach (\App\Models\Menu::get() as $list_menu)
                                                    <option value="{{$list_menu->id}}">
                                                        {{ $list_menu->menu_name }} - <small>{{$list_menu->menu_poistion}}</small>
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="body mt-4">
                            <h5><strong>SEO </strong> Settings</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <strong>
                                            Meta Title
                                            <sub>
                                                Title that is displayed in google search bar
                                            </sub>
                                        </strong>
                                        <input value="{{ old('meta_title') }}" type="text" name="meta_title" id="metai_title" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>
                                            Meta keyword
                                            <sub>
                                                Search Keyword, use comma seperated value
                                            </sub>
                                        </strong>
                                        <input type="text" value="{{ old('meta_keyword') }}" name="meta_keyword" class="form-control" id="meta_keyword" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Meta Description
                                            <sub>
                                                Description that will be shown on google search
                                            </sub>
                                        </strong>
                                        <textarea name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="zmdi zmdi-plus"></i>
                                        &nbsp;
                                        Save Menu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <div class="moda-body">
                <p>Please wait...loading your data</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea',
            toolbar_mode: 'floating'
        })
    });
</script>
@endsection