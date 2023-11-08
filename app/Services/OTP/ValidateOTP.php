<?php

namespace App\Services\OTP;

use App\Exceptions\AppException;
use App\Models\OtpCode;
use Carbon\Carbon;

class ValidateOTP
{
    /**
     * Validate otp.
     */
    public function execute(array $data): OtpCode
    {
        //in the place of code
        $check_otp = OtpCode::where(['ref' => $data['type'], 'email' => $data['email'], 'code' => $data['reference_code']])->orderBy('id', 'DESC')->first();
        if ($check_otp) {
            $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(Carbon::now());
            if ($totalDuration > 1) {
                throw new AppException('otp expired');
            }

            return $check_otp;
        }
        throw new AppException('Invalid OTP verification code.');
    }
}
