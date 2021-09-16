<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use App\Models\TwoFactor;
use App\Models\RegisteredDevice;
use App\Models\Role;
use App\Models\Permission;




class LoginController extends Controller
{


    public function login(LoginRequest $request)
    {

        // cadmanedwards1000@gmail.com


        $user = User::with(['role:id,role,role_slug'])->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {

		    return response()->json([
                'status' => false,
                'errors' => ['Email or Passwor is incorrect']
                ],422); 

        }



        // $this->store_two_factor($user->id);

        return response()->json([
            'token' => $user->createToken('myApp')->plainTextToken,
            'user' => $user
        ], 200); 
        
    }

    public function me(Request $request){

        $user = $request->user();
        
        $permissions =  Permission::whereRoleId($user->role_id)->pluck('permission')->toArray();

        $user->canAdd = in_array("add", $permissions) ?  true : false ;
        $user->canEdit = in_array("edit", $permissions) ?  true : false ;
        $user->canView = in_array("view", $permissions) ?  true : false ;
        $user->canDelete = in_array("delete", $permissions) ?  true : false ;

      

		return [ 'user' => $user ]; 
	}


    public function store_two_factor($id)
    {
        $randomNumber = random_int(100000, 999999); 

        return TwoFactor::create([
            'code' => $randomNumber,
            'expire_at' => now()->addMinute(10),
            'user_id' => 1
        ]);
  
    }

 
    public function verfiy(Request $request)
    {

        $response = TwoFactor::where('user_id',$request->id)->where('code',$request->code)->update([
            'verified' => 1,
            'code' => 0
        ]);

        $response = $response 
            ?  [ 'payload' => '', 'message' => 'Verified','status' => true ]
            :  [ 'payload' => '', 'message' => 'Not Verified','status' => false ];

        return response()->json($response,200);
        
    }

    public function index()
    {        
        // return TwoFactor::get();
    }

}
