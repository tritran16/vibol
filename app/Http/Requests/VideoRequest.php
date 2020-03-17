<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Factory as ValidationFactory;

class VideoRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'youtube',
            function ($attribute, $value, $parameters) {
                $rx = '~
                      ^(?:https?://)?                           # Optional protocol
                       (?:www[.])?                              # Optional sub-domain
                       (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
                       ([^&]{11})                               # Video id of 11 characters as capture group 1
                        ~x';

                $has_match = preg_match($rx, $value, $matches);
                return $has_match;
            },
            'Invalid youtube link'
        );

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
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'link' => 'required|string|max:1000|youtube'
        ];
        
        if ($this->getMethod() == 'POST') {
            $rules += [
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:4000'
            ];
        }
        return  $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
