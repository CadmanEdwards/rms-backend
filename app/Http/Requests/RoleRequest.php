<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\failedValidation;


class RoleRequest extends FormRequest
{
    use failedValidation; // give response when validation failed

    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'required|max:10',
            'role_slug' => 'required',
        ];
    }
}
