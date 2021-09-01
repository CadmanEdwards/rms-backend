<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::post('login', [LoginController::class,'login']);

Route::get('me', [LoginController::class,'me']);

Route::resource('role',RoleController::class);
Route::post('role/permissions',[RoleController::class,'permissions']);


Route::resource('user',UserController::class);


