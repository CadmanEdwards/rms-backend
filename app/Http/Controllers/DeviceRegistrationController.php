<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RegisteredDevice;

class DeviceRegistrationController extends Controller
{
    public function index()
    {
        
    }
    public function register_temp(Request $request)
    {
        try {
            $response = RegisteredDevice::create($this->setFields($request,'register_perm'));
            return $this->set_SR('El dispositivo ha sido registrado');
            
        } catch (\Throwable $th) {
            return $this->set_ER(['El dispositivo no se puede registrar']);
        }
    }

    public function o(Request $request)
    {
        try {
            $response = RegisteredDevice::create($this->setFields($request,'register_perm'));
            return $this->set_SR('El dispositivo ha sido registrado');
            
        } catch (\Throwable $th) {
            return $this->set_ER(['El dispositivo no se puede registrar']);
        }
    }
    public function register_perm(Request $request)
    {
       
        try {
            $response = RegisteredDevice::create($this->setFields($request,'register_perm'));
            return $this->set_SR('El dispositivo ha sido registrado');
            
        } catch (\Throwable $th) {
            return $this->set_ER(['El dispositivo no se puede registrar']);
        }
    }

    public function setFields($request,$state)
    {
        return [

            "usuario_ban" => $request->user,
            "codigo_ban" => '0001',
            "token_equ" => \Hash::make($request->namemachine),
            "estado" => $request->action,
            "nombre" => $request->namemachine,
            "fecha_aut" => now(),
            "codigo" => $request->cod

        ];
    }
    
    public function set_ER($msgs)
    {
        return response()->json([
            'status' => false,
            'errors' => $msgs
            ],422); 
    }

    public function set_SR($msg)
    {
        return response()->json([
            'status' => true,
            'response' => $msg
        ], 200); 

    }


}
