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

Route::namespace('Api')->middleware('cors')->group(function () {
    Route::middleware('admin.guard')->group(function () {
        //管理员注册
        Route::post('/admin/store', 'AdminController@store')->name('admin.store');
        //管理员登录
        Route::post('/admin/login', 'AdminController@login')->name('admin.login');
        Route::middleware('admin.refresh')->group(function () {
            //当前管理员信息
            Route::get('/admin/info', 'AdminController@info')->name('admin.info');
            //管理员列表
            Route::get('/admin', 'AdminController@index')->name('admin.index');
            //管理员信息
            Route::get('/admin/{user}', 'AdminController@show')->name('admin.show');
            //管理员退出
            Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');
        });
    });
});