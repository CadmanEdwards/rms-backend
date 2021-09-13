<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceRegistrationController extends Controller
{
    public function register_temp(Request $request)
    {
        // @usu, @tokenlaravel, @namemachine,@form

        try {

            $usu = $request->user; // dynamic
            $cla = ''; // dynamic
            $tokenlaravel = 'tokenlv';
            $orde = 'register_temp';
            $namemachine = $request->namemachine;
            $cod = $request->cod;
            $form = 'fsql';

             $response =  \DB::select("CALL bl_ent_ban('$usu','$cla','$tokenlaravel','$orde','$namemachine','$cod','$form')");

            if($response && $response[0]->e == 0){

                return response()->json([
                    'status' => false,
                    'errors' => [$response[0]->m ?? '']
                    ],422); 

            }

            return response()->json([
                'status' => true,
                'response' => $response
                ],200); 

    } catch (\Exception $e) {
        return $e;
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }


    }
    public function o(Request $request)
    {
        try {

            $usu = $request->user; // dynamic
            $cla = ''; // dynamic
            $tokenlaravel = 'tokenlv';
            $orde = 'o';
            $namemachine = $request->namemachine;
            $cod = $request->cod;
            $form = 'fsql';

             $response =  \DB::select("CALL bl_ent_ban('$usu','$cla','$tokenlaravel','$orde','$namemachine','$cod','$form')");

            if($response && $response[0]->e == 0){

                return response()->json([
                    'status' => false,
                    'errors' => [$response[0]->m ?? '']
                    ],422); 

            }


            return response()->json([
                'status' => true,
                'response' => $response
            ], 200); 


    } catch (\Exception $e) {
        return $e;
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }


    }
    public function register_perm(Request $request)
    {
        try {

            $usu = $request->user; // dynamic
            $cla = ''; // dynamic
            $tokenlaravel = 'tokenlv';
            $orde = 'register_perm';
            $namemachine = $request->namemachine;
            $cod = $request->cod;
            $form = 'fsql';

             $response =  \DB::select("CALL bl_ent_ban('$usu','$cla','$tokenlaravel','$orde','$namemachine','$cod','$form')");

            if($response && $response[0]->e == 0){

                return response()->json([
                    'status' => false,
                    'errors' => [$response[0]->m ?? '']
                    ],422); 

            }

            return response()->json([
                'status' => true,
                'response' => $response
            ], 200); 


    } catch (\Exception $e) {
        return $e;
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }


    }
}
