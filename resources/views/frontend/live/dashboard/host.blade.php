<?php
$roles = App\Models\Role::$roles;
if ($program->live && $program->live->live) :
    if (array_key_exists(user()->role_id, $roles) && $roles[user()->role_id] == 'Admin') :
?>
        <form action="{{ route('user.account.event.live_as_admin',[$program->live->id]) }}" method="post">
            @csrf
            <button onclick="this.innerText='Please wait...';" type="submit" class="fw-semibold btn btn-sm btn-success">
                Join as Host
            </button>
        </form>
<?php
    endif;
endif;
?>