<?php

namespace App\Http\Requests\Web;

use App\Models\Arraysets\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TranslateRequest extends FormRequest
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
            'from'       => 'required|string|in:' . Lang::implodeIds(),
            'to'         => 'required|string|in:' . Lang::implodeIds(),
            'source'     => 'nullable|string|max:9500',
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

