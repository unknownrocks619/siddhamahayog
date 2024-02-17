@php
    $users = \App\Models\AdminUser::whereNull('center_id')->whereIn('role_id',App\Models\Role::CENTER_USER_ADD_LIST)
                                    ->get();

@endphp
<form class="ajax-form" method="post"
      action="{{ route('admin.users.modal-user-list', ['center' => $center]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Select Existing User</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="user-list">Select User</label>
                    <select multiple name="user_list[]" id="user-list" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{{$user->getKey()}}}">{{$user->full_name()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-between">
                <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-block">Add Staff</button>
            </div>
        </div>
    </div>
</form>
<script>
    window.select2Options();
</script>