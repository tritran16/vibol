<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class AboutRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {

    }
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

            'content' => 'required|max:80000',
            'video_link' => 'required|active_url'
        ];


        return  $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
