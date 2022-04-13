<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

    }

    public function store(StoreUserRequest $request)
    {

    }

    public function show(User $user)
    {
        
    }

    public function update(UpdateUserRequest $request, User $user)
    {

    }

    public function destroy(User $user)
    {
    }
}
