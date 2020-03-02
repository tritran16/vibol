<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $rules =  [
            'name' => 'required|string|max:255',
            'pdf_file' => 'required_without:link|max:8000', // |mimes:pdf
            'link' => 'required_without:pdf_file|nullable|string|max:1000',
            'status' => 'required',
            'description' => 'nullable|string|max:1000',
            'page_number' => 'required|integer|min:1'
        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:4000'
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
