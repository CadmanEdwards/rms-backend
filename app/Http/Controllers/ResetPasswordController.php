<?php

namespace App\Http\Controllers;

use App\Models\ResetPassword;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;


use Hash;

use App\Http\Requests\PasswordUpdate;


use Str;

class ResetPasswordController extends Controller
{

    public function index()
    {
        $response = [ 'link' => 'http://localhost:3000/' ];
        Mail::to('francisgill1000@gmail.com')->send(new PasswordReset($response));

        return new PasswordReset($response);

    }
    public function reset_password_link($token)
    {
        
        $response = ResetPassword::whereIn('token',[$token])->first();

        if(!$response){
            return [
                'status' => false,
                'errors' => ['Your reset password link is invalid'],
            ];
        }

        
        return [
            'status' => true,
            'email' => $response->email,
        ];
      

    }
    public function reset_password(Request $request)
    {

        $response = User::whereIn('email',[$request->email])->first();

        if(!$response){

            return response()->json([
                'status' => false,
                'errors' => ['We do not have your Email Address'],
            ]);    
            
        }


        $count = ResetPassword::where('email',$request->email)->count();

        // $count = 1;

        if($count >= 5){
            return response()->json([
                'status' => false,
                'errors' => ['you can not reset password more than 5 times']
            ]);
        }

        $token = Str::random(60);

        // $link = 'http://45.32.48.38/resetPassword/'. $token;
        $link = 'http://localhost:3000/resetPassword/'. $token;
        
        $arr = [
            'email' => $request->email,
            'link' => $link,
            'expire' => 60,
            'count' => ++$count,
            'token' => $token
        ];
      
       try {

        $response = ResetPassword::create($arr);

        if($response){

           Mail::to($request->email)->send(new PasswordReset(['link' => $link]));

        }

        return response()->json([
            'status' => true,
            'message' => [
                'Password reset link has been sent to your email.',
                // 'Link will expire with in 60 minutes.'
                ]
        ]);
       } catch (\Throwable $th) {
           throw $th;   
       }
        
    }

   
    public function reset_password_update(PasswordUpdate $request)
    {
        $validated = $request->validated();

        $response = ResetPassword::whereIn('token',[$request->token])->whereIn('email',[$validated['email']])->first();

        if(!$response){
            return [
                'status' => false,
                'errors' => ['Your credentails does not exist'],
            ];
        }

        try {


            User::where('email',$validated['email'])->update([ 
                'password' => Hash::make($validated['password'])
            ]);

            ResetPassword::whereIn('email',[$validated['email']])->delete();

    
            return response()->json([
                'status' => true,
                'message' => ['Password has been reset']
            ]);
           } catch (\Throwable $th) {
            //    throw $th;
           }

       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResetPassword  $resetPassword
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResetPassword $resetPassword)
    {
        //
    }
}
