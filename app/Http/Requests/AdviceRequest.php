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
        $rules = [
            'advice' => 'nullable|required_if:type,==,1|string|max:1000',
            'author' => 'nullable|string|max:100',
            //'image' => 'required_if:type,==,1|mimes:jpeg,png,jpg,gif,svg|max:8000',
            'video_file' => 'nullable|mimes:mp4|max:16000',
            'video' => 'nullable|url',
        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'image' => 'required_if:type,==,1|mimes:jpeg,png,jpg,gif,svg|max:8000',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'advice.required' => 'Advice content is required!',
            'author.max' => 'Author is length must be less than 100',
        ];
    }
}
