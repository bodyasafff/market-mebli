<?php

namespace App\Http\Requests\Dashboard\User;

use App\Models\Datasets\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AjaxUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'status_id' => 'nullable|integer|in:' . UserStatus::implodeIds(),
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

