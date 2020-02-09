<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'link' => 'required|string|max:1000|youtube'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'description.max' => 'Content is length must be less than 1000',
        ];
    }
}
