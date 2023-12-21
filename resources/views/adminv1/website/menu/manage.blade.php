@extends("layouts.portal.app")


@section("title")
:: Menu :: Manage
@endsection

@section("plugins_css")
<link rel="stylesheet" href="{{ asset ('admin/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endsection

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                                Manage
                            </strong>
                            Modules
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a data-toggle="modal" data-target="#menu_module" href="{{ route('admin.website.menus.link_module_options',$menu->id) }}" class="btn btn-outline-primary btn-xs link_module">
                                    <x-plus>
                                        Link Module
                                    </x-plus>
                                </a>
                                <a href="{{ route('admin.website.menus.admin_menu_list') }}" class="btn btn-outline-info">
                                    <x-arrow-left>Go Back</x-arrow-left>
                                </a>
                            </div>
                        </div>
                        <table class=" table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Module Type</th>
                                    <th>
                                        <?php
                                        if ($pages) {
                                            echo "Page Name";
                                        } else if ($posts) {
                                            echo "Post Title";
                                        } else if ($courses) {
                                            echo "Course Title";
                                        } elseif ($category) {
                                            echo "Category Name";
                                        }
                                        ?>
                                    </th>
                                    <th></th>
                                </tr>
                            <tbody>
                                @if($pages)
                                @foreach ($pages->pages as $page)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ __("menu.".$menu->menu_type) }}
                                    </td>
                                    <td>
                                        {{ $page->page_name }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.website.menus.deatch_module',[$menu->id,$page->id]) }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" name="type" value="pages" />
                                            <button type="submit" class="btn btn-outline-danger btn-xs">
                                                <x-trash>Remove</x-trash>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("modal")
<x-modal modal="menu_module">
</x-modal>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

<script src="{{ asset ('admin/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset ('admin/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script>
    $(function() {
        'use strict';

        $(function() {
            $('#menu_table').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "All"]
                ],
                "iDisplayLength": 10,
                "language": {
                    search: ""
                }
            });
            $('#menu_table').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        });

        var $menus = $(".sortable");
        // $(".sortable").sortable({
        //     // cancel: "thead",
        //     // items: "tr.parent_menu",
        //     connectWith: '.sortable',

        //     stop: function(event, ui) {
        //         var items = $(ui.item).parent().sortable('toArray', {
        //             attribute: 'data-id'
        //         });
        //         var ids = $.grep(items, (item) => item !== "");

        //         // let $category = $(ui.item).parent();
        //         // var items = $category.sortable('toArray', {
        //         //     attribute: 'data-id'
        //         // });
        //         // var ids = $.grep(items, (item) => item !== "");
        //         $.post("{{-- route('admin.menu.reorder') --}}", {
        //             _token: "{{csrf_token()}}",
        //             ids,
        //             menu_id: $(ui.item).parent().data('id')
        //         }).done(function(response) {
        //             console.log(response);
        //         }).fail(function(response) {
        //             console.log(response);
        //         })
        //     }
        // });
    });
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