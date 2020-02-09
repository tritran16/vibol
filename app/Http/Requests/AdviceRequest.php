<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdviceRequest extends FormRequest
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
            'advice' => 'required|string|max:1000',
            'author' => 'nullable|string|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8000',
        ];
    }

    public function messages()
    {
        return [
            'advice.required' => 'Advice content is required!',
            'author.max' => 'Author is length must be less than 100',
        ];
    }
}
