<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'type' => 'required|unique:banners,type,' . request('id'),
            'title' => 'required',
           // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:8000',
            'content' => 'required',
        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8000'
            ];
        }
        else if ($this->getMethod() == 'PUT') {
            $rules += [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000'
            ];

        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Title English is required!',
            'content.required' => 'Title Khmer is required',
        ];
    }
}
