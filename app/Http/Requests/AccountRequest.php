<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class AccountRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:admin_accounts,name,'. request('id'),
            'account_id' => 'required|string|max:100',
            'account_name' => 'required|string',
            'account_link' => 'required|url'
        ];

        return  $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
