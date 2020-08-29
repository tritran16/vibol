<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required|max:3000',
            'link' => 'required|url'
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
            'title.required' => 'Title  is required!',
            'description.required' => 'Description is required',
        ];
    }
}
