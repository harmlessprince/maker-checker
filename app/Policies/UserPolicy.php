<?php

namespace App\Policies;

use App\Enums\Messages;
use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
        return  $user->role == UserRoles::ADMIN  ? Response::allow() : Response::deny(Messages::ADMIN_ACCESS_REQUIRED);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        return  $user->role == UserRoles::ADMIN || $model->id == $user->id  ? Response::allow() : Response::deny(Messages::DENY_MESSAGE);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return  $user->role == UserRoles::ADMIN  ? Response::allow() : Response::deny(Messages::ADMIN_ACCESS_REQUIRED);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        return  $user->role == UserRoles::ADMIN || $user->id == $model->id  ? Response::allow() : Response::deny(Messages::DENY_MESSAGE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return  $user->role == UserRoles::ADMIN || $user->id == $model->id  ? Response::allow() : Response::deny(Messages::DENY_MESSAGE);
    }


}
