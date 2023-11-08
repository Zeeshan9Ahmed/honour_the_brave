<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class WebSignUpRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@!$#%]).*$/',

            ],
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
