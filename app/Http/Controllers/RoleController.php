<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Validator;

use App\Models\Permission;

class RoleController extends Controller
{
 
    public function index()
    {
        return Role::with('permissions')->get();
    }
   
    public function store(RoleRequest $request)
    {
        return $this->doJob(
                  'added',
                   Role::create($request->validated()),
                   $request
                );
    }

    public function update(RoleRequest $request, Role $role)
    {   
        return $this->doJob(
                'updated',
                 $role->update($request->validated()),
                 $request,
                 $role->id
            );
    }

   
    public function show(Role $role)
    {
        return Role::with('permissions')->find($role->id);
    }

    public function destroy(Role $role)
    {

        try {

            $response = $role->delete()
            ? [ 'message' => 'Role has been deleted', 'status' => true ]
            : [ 'message' => 'Role can not delete', 'status' => false ];

            Permission::where('role_id',$role->id)->delete();

            return response()->json($response,200);

        } catch (\Throwable $th) {
            throw $th;
        }
       
    }

   
    public function setPermissions($role_id,$permissions)
    {
        Permission::where('role_id',$role_id)->delete();

        foreach($permissions as $permission){
            Permission::create( ['role_id' => $role_id,'permission' => $permission] );
        }
        
    }

    public function doJob($action,$job,$request,$id = null)
    {
        
        try {

             $last_id = gettype($job) == 'object' ? $job->id : $id;

            if($job && $request->permissions){
                $this->setPermissions( $last_id,$request->permissions);
            }

            $response = [
                'payload' => Role::with('permissions')->find($last_id), 
                'message' => 'Role has been ' . $action,
                'status' => true
            ];
    
            return response()->json($response,200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
