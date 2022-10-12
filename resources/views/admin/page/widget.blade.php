@extends("themes.admin.master")

@section("title")
:: Pages ::{{ $page->page_name }} :: Widget Manager
@endsection

@section("plugins_css")
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endsection

@section("content")
<x-layout heading="Widget Resource">
    <div class="card">
        <div class="card-body">
            <a data-bs-toggle='modal' data-bs-target="#add_widget" class="btn btn-secondary mb-3 add_widget" href="{{ route('admin.page.add_widget',$page->id) }}">
                <x-plus>Add More Widget</x-plus>
            </a>
            <a class="btn btn-danger mb-3" href="{{ route('admin.page.page.index') }}">
                <x-arrow-left>Go Back</x-arrow-left>
            </a>
            <table class="table-bordered table">
                <thead>
                    <tr>
                        <th>Widget Title</th>
                        <th>Widget Type</th>
                        <th>
                            Position
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($page->widget as $widget)
                    <tr>
                        <td>{{ $widget->widget_name }}</td>
                        <td>{{ __("widget".$widget->widget_type) }}</td>
                        <td>

                        </td>
                        <td>
                            <form action="{{ route('admin.page.destroy_widget',[$page->id,$widget->id]) }}" method="post" style="display:inline">
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
</x-layout>
@endsection


@section("modal")
<x-modal modal="add_widget"></x-modal>
@endsection

@push("custom_script")
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $(document).on('click', '.add_widget', function(event) {
        event.preventDefault();
        $.get($(this).attr('href'), function(response) {
            $("#add_widget").html(response);
        })
    })
</script>
@endpush