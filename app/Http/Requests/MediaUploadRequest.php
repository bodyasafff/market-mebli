<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
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
            'media' => 'nullable|mimes:jpeg,png,jpg,gif,mp4|max:100000000',
            //'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,bmp,mp4,ogg|max:100000000',
            //'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,bmp,wmv,asf,wmx,wvx,avi,mp4,mov,ogg,qt,flv,m4v,avchd,swf,mpg,mpeg,mpeg-4,divx,3gp|max:131000',
            //'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,bmp,avi,mp4,mov,ogg,mpg,mpeg,mpeg-4,divx,3gp|max:131000',
        ];
    }
}
