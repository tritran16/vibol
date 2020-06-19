<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
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
            'name' => 'required|max:255',

            'description' => 'nullable|string|max:1000',
            'link' => 'nullable|string|max:255|url'
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8000',
            ];
        }
        else if ($this->getMethod() == 'PUT') {
            $rules += [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'description.max' => 'Content is length must be less than 1000',
        ];
    }
}
