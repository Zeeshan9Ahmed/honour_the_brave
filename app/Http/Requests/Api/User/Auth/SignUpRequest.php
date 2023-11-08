<?php

namespace App\Http\Requests\Api\User\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            // 'full_name' => 'required|min:3',
            // 'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@!$#%]).*$/',

            ],
            'device_type' => 'required|in:ios,android',
            'device_token' => 'required',
            // 'role' => 'required|in:user,artist'
        ];
    }

    public function messages()
    {
        return [
            'password.min' => 'Password should be 8 characters long (should contain uppercase, lowercase, numeric and special character)',
            'password.regex' => 'Password should be 8 characters long (should contain uppercase, lowercase, numeric and special character)',
        ];
    }
}
