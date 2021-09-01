<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Models\User;


class UserController extends Controller
{

    // password_confirmation

    public function index()
    {
        return User::with('role')->where('role_id', '!=' , 0)->get();
    }

   
    public function store(UserRequest $request)
    {  
        return $this->doJob(
            'added',User::create($request->validated()),$request
          );
    }

  
    public function show(User $user)
    {
        return User::with('role')->find($user->id);
    }

    public function update(Request $request, User $user)
    {
        return $this->doJob(
            'updated',
             $user->update($request->all()),
             $request,
             $user->id
        );
    }

 
    public function destroy(User $user)
    {
        try {

            $response = $user->delete()
            ? [ 'message' => 'User has been deleted', 'status' => true ]
            : [ 'message' => 'User can not delete', 'status' => false ];

            return response()->json($response,200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function doJob($action,$job,$request,$id = null)
    {
        
        try {

             $last_id = gettype($job) == 'object' ? $job->id : $id;

            $response = [
                'payload' => User::with('role')->find($last_id), 
                'message' => 'User has been ' . $action,
                'status' => true
            ];
    
            return response()->json($response,200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
