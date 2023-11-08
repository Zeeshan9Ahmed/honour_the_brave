<?php

namespace App\Http\Controllers\Api\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\User\Profile\UpdateProfileRequest;
use App\Http\Resources\LoggedInUser;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = User::with('license_images')->whereId(auth()->id())->first();

        return apiSuccessMessage('Profile Data', new LoggedInUser($user));
    }

    public function completeProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            $avatar = 'uploadedimages'.'/'.$imageName;
            $user->avatar = $avatar;
        }

        $user->full_name = $request->full_name;

        $user->phone_number = $request->phone_number;
        if ($request->zip_code) {
            $user->zip_code = $request->zip_code;
        }

        if ($request->address) {
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
        }

        if ($request->state) {
            $user->state = $request->state;
        }

        if ($user->profile_completed == 0) {
            $user->role = $request->role;
            $user->profile_completed = 1;
        }
        // $user->is_active = 1;

        if ($user->save()) {
            return apiSuccessMessage('Profile Updated Successfully', new LoggedInUser($user));
        }

        return commonErrorMessage('Something went wrong', 400);

    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (! Hash::check($request->current_password, $user->password)) {
            return commonErrorMessage('Current Password is incorrect.', 400);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return commonErrorMessage("Current password and New password can't be same", 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();
        if ($user) {
            return commonSuccessMessage('Password Updated Successfully', 200);
        }

            return commonErrorMessage('Something went wrong while updating old password', 400);

    }

    public function notificationToggle()
    {
        $user = auth()->user();
        // return $user->notification_toggle;
        $message = '';
        if ($user->notification_toggle == 1) {
            $user->notification_toggle = 0;
           $message = 'Notification turned off';

        } else {
            $user->notification_toggle = 1;
           $message = 'Notification turned on';

        }

        $user->save();

        return apiSuccessMessage($message, new LoggedInUser($user));
    }
    public function notifications() 
    {
        $notifications = Notification::with('sender:id,full_name,email,avatar')
                            ->select(
                                'id',
                                'from_user_id',
                                'title',
                                'description',
                                'notification_type',
                                'redirection_id',
                                'created_at',
                            )
                            ->where('to_user_id', auth()->id())
                            ->latest()->get();
        return apiSuccessMessage("Notifications ", $notifications);
    }
}
