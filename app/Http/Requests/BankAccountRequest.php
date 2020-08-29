<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
            'account' => 'required|max:255',
            'owner' => 'required|max:255',
            'description_en' => 'required|max:8000',
            'description_kh' => 'required|max:8000',
        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:8000',
                 'pdf_file' => 'required|mimes:pdf|max:8000'
            ];
        }
        else if ($this->getMethod() == 'PUT') {
            $rules += [
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000',
                'pdf_file' => 'nullable|mimes:pdf|max:8000'
            ];

        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Title English is required!',
            'description_en.required' => 'Description in English is required',
            'description_kh.required' => 'Description in Khmer is required',
        ];
    }
}
