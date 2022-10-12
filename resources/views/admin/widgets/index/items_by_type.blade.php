@extends("themes.admin.master")

@section("title")
{{ $widget_type }}
@endsection

@section("content")
<x-layout heading="{{ __('widget.'.$widget_type) }}">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.web.widget.index') }}" class="btn btn-xs btn-primary mb-3">
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
                            <a href="{{ route('admin.web.widget.edit',[$widget->id]) }}" class="btn btn-outline-primary btn-xs">
                                <x-pencil>
                                    Edit
                                </x-pencil>
                            </a>
                            <form style="display:inline" action="{{ route('admin.web.widget.destroy',[$widget->id]) }}" method="post">
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
</x-layout>
@endsection