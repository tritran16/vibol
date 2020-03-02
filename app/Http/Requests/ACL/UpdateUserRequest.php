<?php

namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('user');

        return [
            'name'     => 'required|max:40',
            'email' => 'required|email|max:100|unique:users,email,' .$id,
            'password' => 'nullable|max:20'
        ];
    }
}
