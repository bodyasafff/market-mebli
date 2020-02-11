<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\Datasets\DeviceType;
use Illuminate\Foundation\Http\FormRequest;

class ValidationDeviceUidRequest extends FormRequest
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
            'device_uid' => 'required|string|min:6|max:50|unique:users',
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

