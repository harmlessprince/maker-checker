<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return $this->respondSuccess([], 'User creation request submitted successfully');
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);
        return $this->respondWithResource(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->role = $request->role;
        $user->update();
        return $this->respondSuccess([], 'User profile has been submitted for update');
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return $this->respondSuccess([], 'User profile has been submitted for deletion');

    }
}
