@extends("layouts.portal.app")

@section("title")
Pages
@endsection

@section("plugins_css")
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endsection

@section("content")
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <a class="btn btn-secondary mb-3" href="{{ route('admin.page.page.create') }}">
                        <x-plus>Add New Page</x-plus>
                    </a>
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th>Page Title</th>
                                <th>
                                    Page Type
                                </th>
                                <th>
                                    Permission
                                </th>
                                <th>
                                    Widget
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                            <tr>
                                <td>{{ $page->page_name }}</td>
                                <td>{{ __("page.".$page->page_type) }}</td>
                                <td>
                                    {{ __("page.".$page->display) }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.page.manage_widget',$page->id) }}">Manage Widget</a>
                                    |
                                    <a href="{{ route('admin.page.add_widget',[$page->id]) }}" data-toggle='modal' data-target='#add_widget' class="add_widget">Add Widget</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.page.page.edit',$page->id) }}" class="btn btn-outline-primary btn-xs">
                                        <x-pencil>
                                            Edit
                                        </x-pencil>
                                    </a>
                                    <form action="{{ route('admin.page.page.destroy',$page->id) }}" method="post" style="display:inline">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-outline-danger btn-xs" type="submit">
                                            <x-trash>
                                                Delete
                                            </x-trash>
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
</section>
@endsection


@section("modal")
<x-modal modal="add_widget"></x-modal>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $(document).on('click', '.add_widget', function(event) {
        event.preventDefault();
        $.get($(this).attr('href'), function(response) {
            $("#add_widget").html(response);
        })
    })
</script>
@endsection