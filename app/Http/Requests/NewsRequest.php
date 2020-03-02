<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
       $rules = [
            'title_en' => 'required',
            'short_desc_en' => 'required',
            'content_en' => 'required|string',
            'title_kh' => 'required',
            'short_desc_kh' => 'required',
            'content_kh' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000'

        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];
        }
        return  $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'description.max' => 'Content is length must be less than 1000',
        ];
    }
}
