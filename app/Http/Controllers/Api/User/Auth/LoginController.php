<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\LoginRequest;
use App\Http\Requests\Api\User\Auth\SocialLoginRequest;
use App\Http\Resources\LoggedInUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // if ( $user->email_verified_at == null)
            // {
            //     return commonErrorMessage("Account not verified Please Verify your account", 400);
            // }
            $message = $user->email_verified_at == null ? 'Account not verified Please Verify your account' : 'User login Successfully';

            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->save();
            $user->tokens()->delete();
            $token = $user->createToken('authToken')->plainTextToken;

            return apiSuccessMessage($message, new LoggedInUser($user), $token);
        }

        return commonErrorMessage('Invalid Credientials', 400);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $user->device_type = null;
        $user->device_token = null;
        $user->save();

        return commonSuccessMessage('Logged Out');

    }

    public function socialAuth(SocialLoginRequest $request)
    {
        // return bcrypt("Admin@1234");
        $user = User::where(['social_token' => $request->social_token, 'social_type' => $request->social_type])->first();

        if (! $user) {
            $user = new User();
            // $user->email = $request->email;
            // $user->role = $request->role;
            $user->social_token = $request->social_token;
            $user->social_type = $request->social_type;
            $user->is_social = 1;
            // $user->save();
        }
        if (! $user->email_verified_at) {
            $user->email_verified_at = Carbon::now();
        }

        $user->full_name = $request->full_name;
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->save();
        $user->tokens()->delete();
        $token = $user->createToken('authToken')->plainTextToken;

        return apiSuccessMessage('login Successfully', new LoggedInUser($user), $token);

    }
}
