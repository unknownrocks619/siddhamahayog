<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\EventVideoClass;
use App\Models\userLogin;

class EventVideoClassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @return mixed
     */
    public function viewAny(userLogin $userLogin)
    {
        //
        // return false;
        return ($userLogin->userRoles->role_name == "Admin");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventVideoClass  $eventVideoClass
     * @return mixed
     */
    public function view(userLogin $userLogin, EventVideoClass $eventVideoClass)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @return mixed
     */
    public function create(userLogin $userLogin)
    {
        //
        return ($userLogin->userRoles->role_name == "Admin");

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventVideoClass  $eventVideoClass
     * @return mixed
     */
    public function update(userLogin $userLogin, EventVideoClass $eventVideoClass)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventVideoClass  $eventVideoClass
     * @return mixed
     */
    public function delete(userLogin $userLogin, EventVideoClass $eventVideoClass)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventVideoClass  $eventVideoClass
     * @return mixed
     */
    public function restore(userLogin $userLogin, EventVideoClass $eventVideoClass)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventVideoClass  $eventVideoClass
     * @return mixed
     */
    public function forceDelete(userLogin $userLogin, EventVideoClass $eventVideoClass)
    {
        //
    }
}
