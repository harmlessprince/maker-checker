<?php

namespace App\Policies;

use App\Enums\ApprovalStatus;
use App\Enums\Messages;
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
        return  $user->role == UserRoles::ADMIN  ? Response::allow() : Response::deny(Messages::ADMIN_ACCESS_REQUIRED);
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
        return  $user->role == UserRoles::ADMIN  ? Response::allow() : Response::deny(Messages::ADMIN_ACCESS_REQUIRED);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
      return  $user->role == UserRoles::ADMIN ? Response::allow() : Response::deny(Messages::ADMIN_ACCESS_REQUIRED);
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
       
        if ($approval->status != ApprovalStatus::PENDING){
            $status = $approval->status;
            return Response::deny("You are not allowed to act on a request that has been {$status}");
        }
        if ($user->role != UserRoles::ADMIN || $user->id == $approval->created_by){
         
            return Response::deny('Only administrators that didn\'t initiate approval are allowed perform approval');
        }
        return  true;
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
        return  $user->role == UserRoles::ADMIN && $user->id != $approval->created_by ? Response::allow() :  Response::deny(Messages::DENY_MESSAGE);
    }
}
