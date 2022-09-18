@extends("frontend.theme.portal")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Notes</h4>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
                <h5 class="m-0 me-2">Private Notes</h5>
                <small class="text-muted">All your notes are private. You and only you can see these notes.</small>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-success clickable" data-href="{{ route('user.account.notes.notes.create') }}" type="button" id="orederStatistics">
                    <i class='bx bxs-file-plus'></i>
                    Create New Note
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover-table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notes as $note)
                    <tr>
                        <td>

                        </td>
                        <td>
                            {{ $note->title }}
                        </td>
                        <td>
                            <!-- <a href="">View</a> | -->
                            <a href="{{ route('user.account.notes.notes.edit',$note->id) }}">Edit</a> |
                            <form onclick="return confirm('This action cannot be undone. You are about to delete your note. This note is private and only you can view. Do you still want to continue ?')" class="d-inline ms-0 ps-0" action="{{ route('user.account.notes.notes.destroy',$note->id) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-link ms-0 ps-0 text-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="3">You don't have any notes saved.</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection