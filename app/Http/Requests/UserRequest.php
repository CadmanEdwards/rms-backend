<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\failedValidation;


class UserRequest extends FormRequest
{    
    use failedValidation; // give response when validation failed

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
            'role_id' => 'required',

        ];
    }

    // public function setFields()
    // {
    //     return [
    //         'name' => $this->name,
    //         'email' => $this->email,
    //         'password' => \Hash::make($this->password),
    //         'role_id' => $this->role_id,

    //     ];
    // }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'password' => \Hash::make($this->password),
    //     ]);
    // }
}
