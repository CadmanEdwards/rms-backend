<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\NewPasswordController;





Route::post('login', [LoginController::class,'login']);

Route::get('me', [LoginController::class,'me']);

Route::resource('role',RoleController::class);
Route::post('role/permissions',[RoleController::class,'permissions']);


Route::resource('user',UserController::class);

// Route::post('reset_password', [ResetPasswordController::class,'reset_password']);
// Route::get('reset_password_link/{token}', [ResetPasswordController::class,'reset_password_link']);
Route::post('reset_password_update', [ResetPasswordController::class,'reset_password_update']);
// shaheed work
Route::post('forget-password', [NewPasswordController::class,'forget_password']);
Route::post('reset-password', [NewPasswordController::class,'reset']);

