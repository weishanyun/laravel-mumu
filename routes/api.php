<?php

use Illuminate\Http\Request;

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

Route::post('/auth/login',['uses'=>'AuthController@login','desc'=>'登录'])->name('login');

Route::middleware(['auth:api'])->group(function (){
    Route::get('/me', ['uses'=>'MeController@me','desc'=>'登录信息'])->name('me');

    Route::get('/permission', ['uses'=>'PermissionController@index','desc'=>'权限列表'])->name('permission.index');
    Route::post('/permission', ['uses'=>'PermissionController@store','desc'=>'添加权限'])->name('permission.store');
    Route::put('/permission/{id}', ['uses'=>'PermissionController@store','desc'=>'修改权限'])->name('permission.put');

    Route::get('/role', ['uses'=>'RoleController@index','desc'=>'角色列表'])->name('role.index');
    Route::post('/role', ['uses'=>'RoleController@store','desc'=>'添加角色'])->name('role.store');
    Route::put('/role/{id}', ['uses'=>'RoleController@update','desc'=>'修改角色'])->name('role.put');
});

