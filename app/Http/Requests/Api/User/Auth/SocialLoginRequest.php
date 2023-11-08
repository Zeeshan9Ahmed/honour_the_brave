<?php

namespace App\Http\Requests\Api\User\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SocialLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'social_type' => 'required',
            'social_token' => 'required',
            // 'email' => 'required',
            'device_type' => 'required|in:ios,android',
            'device_token' => 'required',
            // 'role' => 'required|in:armed_forces,fire_fighters'
        ];
    }
}
