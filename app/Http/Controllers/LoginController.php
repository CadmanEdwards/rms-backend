<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();



        if (! $user || ! Hash::check($request->password, $user->password)) {

		    return response()->json(['error'=>'email or password is incorrect'], 200); 

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
