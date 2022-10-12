@extends("themes.admin.master")

@section("title")
Pages
@endsection

@section("plugins_css")
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endsection

@section("content")
<x-layout heading="All Posts">
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                Wordpress Integration Failed. Displaying Core Post fields.
            </div>
            <a class="btn btn-secondary mb-3" href="{{ route('admin.posts.post.create') }}">
                <x-plus>Add New Post</x-plus>
            </a>
            <table class="table-bordered table">
                <thead>
                    <tr>
                        <th>Post Title</th>
                        <th>Post Type</th>
                        <th>Post Status</th>
                        <th>Widgets</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title}}</td>
                        <td>{{$post->post_type}}</td>
                        <td>{!! ($post->active) ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>" !!}</td>
                        <td>
                            <a href="{{ route('admin.posts.widgets',$post->id) }}" class="btn btn-outline-info btn-xs">
                                <x-plus>Widgets</x-plus>
                            </a>
                        </td>
                        <td>
                            <a href="" class="btn btn-outline-info btn-xs">Manage Widgets</a>
                            <a href="{{ route('admin.posts.post.edit',$post->id) }}" class="btn btn-outline-primary btn-xs">
                                <x-pencil>Edit</x-pencil>
                            </a>
                            <form class="d-inline" action="{{ route('admin.posts.post.destroy',$post->id) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-outline-danger btn-xs">
                                    <x-trash>Delete</x-trash>
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