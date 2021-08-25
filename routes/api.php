<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::group(['middleware' => 'auth:api'], function (){
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');

    Route::get('user', 'App\Http\Controllers\UserController@user');
    Route::get('chart', 'App\Http\Controllers\DashboardController@chart');
    Route::put('user/info', 'App\Http\Controllers\UserController@updateInfo');
    Route::put('user/password', 'App\Http\Controllers\UserController@updatePassword');
    Route::post('upload', 'App\Http\Controllers\ImageController@upload');
    Route::get('export', 'App\Http\Controllers\OrderController@export');

    Route::apiResource('users', 'App\Http\Controllers\UserController');
    Route::apiResource('roles', 'App\Http\Controllers\RoleController');
    Route::apiResource('products', 'App\Http\Controllers\ProductController');
    Route::apiResource('orders', 'App\Http\Controllers\OrderController')->only('index', 'show');
    Route::apiResource('permissions', 'App\Http\Controllers\PermissionController')->only('index');
});

