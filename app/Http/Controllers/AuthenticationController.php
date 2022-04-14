<?php

namespace App\Http\Controllers;

use App\Enums\Messages;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();
                $token = $user->createToken('api-token')->plainTextToken;
                return $this->respondSuccess(['token' => $token, 'user' => $user], Messages::LOGIN_SUCCESS);
            }
            return $this->respondUnAuthorized(Messages::FAILED_LOGIN);
        } catch (\Exception $exception) {
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * THis logs the user out of the application
     */

    public function logout(Request $request)
    {
        $request->user()->token()->delete();
        return $this->respondSuccess([], Messages::LOGOUT_SUCCESS);
    }

    /**
     * return authenticated user
     */
    public function user()
    {
        return Auth::user();
    }
}
