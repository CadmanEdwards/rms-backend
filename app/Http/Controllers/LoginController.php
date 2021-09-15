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

        $this->store_two_factor($user->id);

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


    public function Login2(Request $request)
    {

        $token = RegisteredDevice::orderBy('id','desc')->first();

        try {
            $usu = $request->user; // dynamic
            $cla = $request->password; // dynamic
            $tokenlaravel = $token->token_equ;
            $orde = 'login';
            $namemachine = '';
            $cod = 1234;
            $form = 'fsql';



            $response =  \DB::select("CALL bl_ent_ban('$usu','$cla','$tokenlaravel','$orde','$namemachine','$cod','$form')");

            if($response && $response[0]->e == 0){

                return response()->json([
                    'status' => false,
                    'errors' => [$response[0]->m]
                    ],422); 

            }

            else if($response && $response[0]->e == 1 && $response[0]->m == 'Registre equipo'){

                return response()->json([
                    'device_registration' => true,
                    ],422); 

            }

            $user = $response[0] ?? 0;

            // return $user;

            return response()->json([
                'token' => $user->token ?? '',
                'user' => $user
            ], 200); 


    } catch (\Exception $e) {
        return $e;
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
  

    }

    public function active_cod(Request $request)
    {
        $response = $this->doJob($request,'active_cod');

        if(!$response){
            return $response;
        }

        return $this->active_user($request);
    }

    public function active_user($request)
    {
        return $this->doJob($request,'active_user');
    }

    public function doJob($request,$action)
    {
        try {
            $usu = $request->user; // dynamic
            $cla = ''; // dynamic
            $tokenlaravel = '';
            $orde = $action;
            $namemachine = '';
            $cod = $request->cod;
            $form = 'fsql';

            $response =  \DB::select("CALL bl_ent_ban('$usu','$cla','$tokenlaravel','$orde','$namemachine','$cod','$form')");

            if($response && $response[0]->e == 0){

                return response()->json([
                    'status' => false,
                    'errors' => [$response[0]->m]
                    ],422); 

            }

            return response()->json([
                'status' => true,
                'messages' => [$response[0]->m]
                ],200); 

            // return $this->active_user($request);

    } catch (\Exception $e) {
        return $e;
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
  

    }

    
}
