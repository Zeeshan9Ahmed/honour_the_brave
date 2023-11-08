<?php

namespace App\Services\OTP;

use App\Exceptions\AppException;
use App\Models\OtpCode;
use App\Models\User;

class AccountVerification
{
    public function execute(array $data): User
    {
        $user = User::where('email', $data['email'])->first();
        if ($user->email_verified_at) {
            throw new AppException('account already verified');
        }
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
        }
        OtpCode::where('email', $user->email)->where('ref', 'ACCOUNT_VERIFICATION')->delete();

        return $user;
    }
}
