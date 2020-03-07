<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'title' => 'required|string|max:1000',
            'notification_type' => 'required|integer',
            'notification_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title of notification is required!',
            'title.max' => 'Title length must be less than 1000',
        ];
    }
}
