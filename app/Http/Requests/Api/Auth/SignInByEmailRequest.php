<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\Datasets\DeviceType;
use Illuminate\Foundation\Http\FormRequest;

class SignInByEmailRequest extends FormRequest
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
            'app_version_code' => 'required|numeric|min:1',
            'device_uid'       => 'required|string|min:6|max:50',
            'one_signal_id'    => 'nullable|string|min:6|max:50',
            'email'            => 'required|string|email|min:6|max:100',
            'password'         => 'required|string|min:6|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}

