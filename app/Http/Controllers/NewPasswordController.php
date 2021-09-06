<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;

class NewPasswordController extends Controller
{
    public function forget_password(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $req->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {

            [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([

            'email' =>[trans($status)],
        ]);
    }

    public function reset(Request $req)
    {
        $this->validate($req, [

            'token'=> 'required',
            'email' => 'required|email',
            'password' => ['required', 'comfirmed'. RulesPassword::defaults()],
        ]);

        $status= Password::reset(

            $req->only('email', 'password', 'password_confirmation', 'token'),

            function($user) use($req){

                $user->forceFill([

                    'password' => Hash::make($req->password),
                    'remember_token' => Str::random(50)

                ])->save();

                $user->tokens()->delete();

                event(new passwordReset($user));

            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);


    }
}
