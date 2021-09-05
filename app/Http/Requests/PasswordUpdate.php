<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\failedValidation;


class PasswordUpdate extends FormRequest
{
    use failedValidation; // give response when validation failed
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'email' => 'required|max:50|email',
            'password' => 'required|confirmed|min:6'
        ];
    }
}
