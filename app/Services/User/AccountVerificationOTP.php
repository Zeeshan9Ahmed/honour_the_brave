<?php

namespace App\Services\User;

use App\Mail\AccountVerificationOTPMail;
use App\Models\OTPCode;
use App\Models\User;
use App\Services\OTP\GenerateOTP;
use Illuminate\Support\Facades\Mail;

class AccountVerificationOTP
{
    /**
     * Create user.
     */
    public function execute(array $data): OTPCode
    {
        $user = $data['user'];
        $otp = app(GenerateOTP::class)->execute(['type' => 'ACCOUNT_VERIFICATION', 'email' => $user->email]);
        // print_r($user->email);
        // Mail::to($user->email)->send(new AccountVerificationOTPMail($user,$otp));
        return $otp;
    }
}
