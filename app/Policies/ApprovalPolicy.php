<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ApprovalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return  $user->role == UserRoles::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Approval $approval)
    {
        return  $user->role == UserRoles::ADMIN;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
      return  $user->role == UserRoles::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Approval $approval)
    {
        return  $user->role == UserRoles::ADMIN && $user->id != $approval->created_by  ? Response::allow()
            : Response::deny('Only administrators that didn\'t initiate approval are allowed perform approval');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Approval $approval)
    {
        return  $user->role == UserRoles::ADMIN && $user->id != $approval->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Approval $approval)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Approval $approval)
    {
        //
    }
}
