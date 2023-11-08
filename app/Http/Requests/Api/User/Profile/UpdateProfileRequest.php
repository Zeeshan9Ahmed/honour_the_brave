<?php

namespace App\Http\Requests\Api\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // 'first_name' => 'required|min:3',
            // 'last_name' => 'required|min:3',
            // 'contact' => 'required',
            // 'avatar' => 'mimes:jpeg,png,jpg,gif',
            // 'license_images.*' => 'mimes:jpeg,png,jpg,gif',
            // 'country_code' => 'required'
            'role' => 'required|in:armed_forces,fire_fighters',
        ];
    }
}
