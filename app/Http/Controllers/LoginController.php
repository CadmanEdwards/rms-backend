<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {

		    return response()->json([
                'status' => false,
                'errors' => ['Email or Passwor is incorrect']
                ],422); 

        }

        return response()->json([
            'token' => $user->createToken('myApp')->plainTextToken,
            'user' => $user
        ], 200); 
        
    }

    public function me(Request $request){
		return response()->json([
            'user' => $request->all()
	],200); 
	}

}
