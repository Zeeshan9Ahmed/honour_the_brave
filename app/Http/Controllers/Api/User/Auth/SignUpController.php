<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ResendSignUpOtpRequest;
use App\Http\Requests\Api\User\Auth\SignUpRequest;
use App\Models\User;
use App\Services\User\AccountVerificationOTP;
use App\Services\User\CreateUser;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        if ($request->password != $request->confrim_password) {
            return commonErrorMessage('password and confrim password does not match', 400);
        }

        $data = $request->only(['email', 'device_type', 'device_token']);
        $data['password'] = bcrypt($request->password);

        $user = app(CreateUser::class)->execute($data);

        $sendOtp = app(AccountVerificationOTP::class)->execute(['user' => $user]);

        return apiSuccessMessage('Sign Up Successfully', ['email' => $user->email]);

    }

    public function resendSignUpOtp(ResendSignUpOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return commonErrorMessage('No User Found', 404);
        }

        if ($user->email_verified_at != null) {
            return commonErrorMessage('Account already verified', 400);
        }

        $otp_code = app(AccountVerificationOTP::class)->execute(['user' => $user]);

        return commonSuccessMessage('We have resend  OTP verification code at your email address', 200);

    }
}
