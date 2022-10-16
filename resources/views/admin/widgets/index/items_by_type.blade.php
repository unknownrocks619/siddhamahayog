@extends("layouts.portal.app")

@section("page_title")
{{ $widget_type }}
@endsection

@section("content")
<section class="content home">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Widget Type:: {{ __("widget.".$widget_type) }}
                    </h4>
                </div>
                <div class="body">
                    <a href="{{ route('admin.widget.index') }}" class="btn btn-xs btn-primary mb-3">
                        <x-arrow-left>
                            Go Back
                        </x-arrow-left>
                    </a>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Widget Name
                                </th>
                                <th>
                                    Layout Type
                                </th>
                                <th>
                                    Bind
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($widgets as $widget)
                            <tr>
                                <td>{{ $widget->widget_name }}</td>
                                <td>
                                    {{ __("widget.".$widget->layouts->layout) }}
                                </td>
                                <td>
                                    None
                                </td>
                                <td>
                                    <a href="{{ route('admin.widget.edit',[$widget->id]) }}" class="btn btn-outline-primary btn-xs">
                                        <x-pencil>
                                            Edit
                                        </x-pencil>
                                    </a>
                                    <form style="display:inline" action="{{ route('admin.widget.destroy',[$widget->id]) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-xs btn-outline-danger">
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


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@endsection