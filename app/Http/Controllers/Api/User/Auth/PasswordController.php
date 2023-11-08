<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\User\Auth\ResetForgotPasswordRequest;
use App\Mail\ForgotPasswordOTPMail;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\OTP\GenerateOTP;
use App\Services\OTP\ValidateOTP;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return commonErrorMessage('Invalid Email', 404);
        }

        // if( $user->email_verified_at === null )
        // {
        //     return commonErrorMessage('You need to verify your account first', 400);
        // }

        $data = ['email' => $user->email, 'type' => 'PASSWORD_RESET'];

        OtpCode::where(['email' => $request->email, 'ref' => 'PASSWORD_RESET'])->delete();
        $otp = app(GenerateOTP::class)->execute($data);

        // Mail::to($user->email)->send(new ForgotPasswordOTPMail($user,$otp));

        return apiSuccessMessage('OTP verification code has been sent to your email address', ['email' => $user->email]);

    }

    public function resetForgotPassword(ResetForgotPasswordRequest $request)
    {
        $check_otp = app(ValidateOTP::class)->execute(['email' => $request->email, 'reference_code' => $request->reference_code, 'type' => 'PASSWORD_RESET']);

        if (! $check_otp) {
            return commonErrorMessage('Invalid Otp ', 400);
        }

            $user = User::where('email', $check_otp->email)->first();
            $user->password = bcrypt($request->new_password);
            $user->save();
            $check_otp->delete();

            return commonSuccessMessage('Password updated successfully');
    }
}
