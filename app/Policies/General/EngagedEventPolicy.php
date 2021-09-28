<?php

namespace App\Policies\General;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\EventFund;
use App\Models\userLogin;

class EngagedEventPolicy
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
        return true;
        return (auth()->check() && $userLogin->account_status);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventFund  $eventFund
     * @return mixed
     */
    public function view(userLogin $userLogin, EventFund $eventFund)
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
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventFund  $eventFund
     * @return mixed
     */
    public function update(userLogin $userLogin, EventFund $eventFund)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventFund  $eventFund
     * @return mixed
     */
    public function delete(userLogin $userLogin, EventFund $eventFund)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventFund  $eventFund
     * @return mixed
     */
    public function restore(userLogin $userLogin, EventFund $eventFund)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\userLogin  $userLogin
     * @param  \App\Models\EventFund  $eventFund
     * @return mixed
     */
    public function forceDelete(userLogin $userLogin, EventFund $eventFund)
    {
        //
    }
}
