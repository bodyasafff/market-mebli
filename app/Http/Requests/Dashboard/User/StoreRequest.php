<?php

namespace App\Http\Requests\Dashboard\User;

use App\Models\Datasets\UserRole;
use App\Models\Datasets\UserStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name'           => 'nullable|string|min:5|max:100',
            'email'          => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($request->id)],
            'role_id'        => 'required|integer|in:' . UserRole::implodeIds(),
            'status_id'      => 'required|integer|in:' . UserStatus::implodeIds(),
            'new_password'   => 'nullable|string|min:6|max:255',
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

