<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DeviceRegistrationController;




// Route::post('login', [LoginController::class,'login']);
Route::post('login', [LoginController::class,'login2']);

Route::get('me', [LoginController::class,'me']);
Route::get('two-factor', [LoginController::class,'index']);

Route::resource('role',RoleController::class);
Route::post('role/permissions',[RoleController::class,'permissions']);


Route::resource('user',UserController::class);

Route::get('reset_password', [ResetPasswordController::class,'index']);
Route::post('reset_password', [ResetPasswordController::class,'reset_password']);
Route::get('reset_password_link/{token}', [ResetPasswordController::class,'reset_password_link']);
Route::post('reset_password_update', [ResetPasswordController::class,'reset_password_update']);


Route::post('register_temp',[DeviceRegistrationController::class,'register_temp']);
Route::post('o',[DeviceRegistrationController::class,'o']);
Route::post('register_perm',[DeviceRegistrationController::class,'register_perm']);

Route::post('active_cod',[LoginController::class,'active_cod']);
Route::post('active_user',[LoginController::class,'active_user']);




