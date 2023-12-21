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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Menus</strong> Available
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li>
                                            <a href="{{ route('admin.website.menus.admin_create_menu') }}">
                                                Add new Menu
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.website.menus.admin_settings') }}">
                                                Settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="menu_table" class="table table-hover table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Menu Name
                                            </th>
                                            <th>
                                                Menu Type
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Position
                                            </th>
                                            <th>SEO</th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menus as $menu)
                                        <tr>
                                            <td>
                                                {{ $menu->id }}
                                            </td>
                                            <td>
                                                {{ $menu->menu_name }}
                                                @if($menu->parent_menu)
                                                <small class="text-info">(Child of ID {{$menu->parent_menu}})</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($menu->menu_type == "page")
                                                <a data-toggle="modal" data-target="#link_module" href="{{ route('admin.website.menus.link_module_options',$menu->id) }}" class="btn btn-outline-primary btn-xs link_module">
                                                    <x-plus>Link Module</x-plus>
                                                </a>
                                                @else
                                                {{ ($menu->menu_type) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($menu->active)
                                                <span class='badge bg-success px-2 text-white'>Active</span>
                                                @else
                                                <span class='badge bg-danger px-2 text-white'>Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                $explode_position = explode("_",$menu->menu_position);
                                                foreach ($explode_position as $position) {
                                                echo ucwords($position) . " ";
                                                }
                                                @endphp
                                            </td>
                                            <td>
                                                @if($menu->meta_keyword && $menu->meta_image && $menu->meta_description)
                                                <button type="butotn" class="btn btn-primary btn-sm">
                                                    <i class="text-white zmdi zmdi-check"></i>
                                                </button>
                                                @else
                                                <button type="butotn" class="btn btn-warning btn-sm">
                                                    <i class="text-white zmdi zmdi-alert-octagon"></i>
                                                </button>

                                                @endif
                                            </td>
                                            <td>
                                                <a class="text-info" href="{{ route('admin.website.menus.manage_module',[$menu->id]) }}">
                                                    Manage Module
                                                </a>
                                                |
                                                <a class="text-info" href="{{ route('admin.website.menus.admin_edit_menu',[$menu->id]) }}">
                                                    Edit
                                                </a>
                                                |
                                                <form class="px-0 mx-0" style="display: inline;" action="{{ route('admin.website.menus.admin_delete_menu',$menu->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-link text-danger">
                                                        <i class="zmdi zmdi-delete"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<div class="modal fade" id="link_module" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="menu_module">
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
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#menu_table').DataTable();
    })
</script>
<script>
    $(document).on('click', '.link_module', function(event) {
        event.preventDefault();
        $.get($(this).attr('href'), function(response) {
            $("#menu_module").html(response);
        })
    })
</script>
@endsection