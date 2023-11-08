<?php

namespace App\Http\Controllers\Web;

use App\Events\CreateBusinessEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\User\Auth\ResendSignUpOtpRequest;
use App\Http\Requests\Api\User\Auth\ResetForgotPasswordRequest;
use App\Http\Requests\Web\WebSignUpRequest;
use App\Models\Category;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\OTP\AccountVerification;
use App\Services\OTP\GenerateOTP;
use App\Services\OTP\ValidateOTP;
use App\Services\User\AccountVerificationOTP;
use App\Services\User\CreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'business'])) {
            $user = Auth::user();
            if ($user->email_verified_at == null) {
                Auth::logout();

                return response()->json([
                    'status' => 1,
                    'redirect_url' => url('/business/otp'),
                    'message' => 'Account is not Verified, please Verify your account',
                    'data' => ['email' => $user->email, 'type' => 'ACCOUNT_VERIFICATION'],
                ]);
            }

            return response()->json([
                'status' => 1,
                'redirect_url' => url('/business/dashboard'),
                'message' => 'Login Successfully',
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalid Credentials',
        ]);
    }

    public function signUp(WebSignUpRequest $request)
    {
        if ($request->password != $request->confirm) {
            return commonErrorMessage('Password and Confirm Password must be same', 200);
        }

        $data = $request->only('full_name', 'email') + ['device_type' => 'web', 'role' => 'business', 'password' => bcrypt($request->password)];

        $user = app(CreateUser::class)->execute($data);

        $sendOtp = app(AccountVerificationOTP::class)->execute(['user' => $user]);

        return response()->json([
            'status' => 1,
            'redirect_url' => url('business/otp'),
            'message' => 'OTP verification code has been sent to your email address',
            'data' => ['email' => $user->email, 'type' => 'ACCOUNT_VERIFICATION'],
        ]);
    }

    public function completeProfile(Request $request)
    {
    
        $social_links = json_encode([
            'website' => $request->website ?? '',
            'facebook' => $request->facebook ?? '',
            'twitter' => $request->twitter ?? '',
            'linkedIn' => $request->linkedIn ?? '',
            'instagram' => $request->instagram ?? '',
        ]);

        $user = Auth::user();

        $user->phone_number = $request->phone_number;
        $user->business_name = $request->business_name;
        if ($request->full_name) {
            $user->full_name = $request->full_name;
        }
        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            $avatar = '/uploadedimages/'.$imageName;
            $user->avatar = $avatar;
        }
        if ($request->address) {
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
        }
        $category = "";
        if ($request->category_id) {
            $user->category_id = $request->category_id;
            $category = Category::find($request->category_id);
        }

        if ($user->profile_completed == 0) {
            //Send Notification Of New Business
            
            $type = $category->category_name=="Resturants"?"resturant":(strtolower($category->category_name));
            $message = "A new $type has been added.";
            event(new CreateBusinessEvent($message));
        }
        
        $user->social_links = $social_links;
        $user->profile_completed = 1;
        $user->save();

        return response()->json([
            'status' => 1,
            'redirect_url' => url('business/dashboard'),
            'message' => 'Profile Updated',
        ]);
    }

    public function otpVerify(Request $request)
    {
        $data = $request->all();
        $reference_code = $data['digit-1'].$data['digit-2'].$data['digit-3'].$data['digit-4'].$data['digit-5'].$data['digit-6'];

        $set_data = $request->only('email', 'type') + ['reference_code' => $reference_code];

        $check_otp = app(ValidateOTP::class)->execute($set_data);

        if ($request->type === 'ACCOUNT_VERIFICATION') {
            $user = app(AccountVerification::class)->execute(['email' => $check_otp->email]);
            $user = Auth::login($user);

            return response()->json([
                'status' => 1,
                'redirect_url' => url('business/complete-profile'),
                // 'message' => '',
                'data' => ['reference_code' => $reference_code],
            ]);
        } elseif ($request->type === 'PASSWORD_RESET') {
            return response()->json([
                'status' => 1,
                'redirect_url' => url('business/change-password'),
                // 'message' => '',
                'data' => ['reference_code' => $reference_code],
            ]);
        }
    }

    public function resetForgotPassword(ResetForgotPasswordRequest $request)
    {
        $check_otp = app(ValidateOTP::class)->execute(['email' => $request->email, 'reference_code' => $request->reference_code, 'type' => 'PASSWORD_RESET']);

        if (! $check_otp) {
            return commonErrorMessage('Invalid OTP verification code. ', 400);
        }

        $user = User::where('email', $check_otp->email)->first();
        $user->password = bcrypt($request->new_password);
        $user->save();
        $check_otp->delete();

        return response()->json([
            'status' => 1,
            'redirect_url' => url('business/login'),
            'message' => 'Password updated successfully',

        ]);
    }

    public function logout()
    {
        // dd('tes');
        if (Auth::user()) {
            Auth::logout();

            // session()->flash('success', 'Log Out Successfully');
            // return redirect()->to('business/login');
            return redirect()->back();

        }

        return redirect()->back();
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return commonErrorMessage('Invalid Email', 200);
        }

        $data = ['email' => $user->email, 'type' => 'PASSWORD_RESET'];

        OtpCode::where(['email' => $request->email, 'ref' => 'PASSWORD_RESET'])->delete();
        $otp = app(GenerateOTP::class)->execute($data);

        // Mail::to($user->email)->send(new ForgotPasswordOTPMail($user,$otp));
        return response()->json([
            'status' => 1,
            'redirect_url' => url('business/otp'),
            'message' => 'OTP verification code has been sent to your email address',
            'data' => ['email' => $user->email, 'type' => 'PASSWORD_RESET'],
        ]);

        return apiSuccessMessage('OTP verification code has been sent to your email address', ['id' => $user->id]);
    }

    public function resendSignUpOtp(ResendSignUpOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return commonErrorMessage('No User Found', 200);
        }

        if ($user->email_verified_at != null) {
            return commonErrorMessage('Account already verified', 200);
        }

        $otp_code = app(AccountVerificationOTP::class)->execute(['user' => $user]);

        return commonSuccessMessage('We have resend  OTP verification code at your email address', 200);
    }
}
