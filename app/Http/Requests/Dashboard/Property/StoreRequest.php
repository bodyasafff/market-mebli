<?php

namespace App\Http\Requests\Dashboard\Property;

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
            'name_ua' => 'nullable|string|min:3|max:100',
            'name_ru' => 'nullable|string|min:3|max:100',
            'name_pl' => 'nullable|string|min:3|max:100',
            'name_en' => 'nullable|string|min:3|max:100',
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

