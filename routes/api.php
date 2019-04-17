<?php

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

Route::namespace ('Api')->middleware('cors')->group(function () {
    Route::middleware('admin.guard')->group(function () {
        //管理员登录
        Route::post('/admin/login', 'AdminController@login')->name('admin.login');
        Route::middleware('admin.refresh')->group(function () {
            //管理员列表
            Route::get('/admins', 'AdminController@index')->name('admin.index');
            //管理员信息
            Route::get('/admins/{admin}', 'AdminController@show')->name('admin.show');
            //保存管理员
            Route::post('/admins', 'AdminController@store')->name('admin.store');
            //删除管理员
            Route::delete('/admins/{admin}', 'AdminController@delete')->name('admin.delete');
            //当前管理员信息
            Route::get('/admin/info', 'AdminController@info')->name('admin.info');
            //管理员退出
            Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');

            Route::get('/admin_menus', 'AdminMenuController@index')->name('adminmenu.index');
            Route::get('/admin_menus/{menu}', 'AdminMenuController@show')->name('adminmenu.show');
            Route::post('/admin_menus', 'AdminMenuController@store')->name('adminmenu.store');
            Route::delete('/admin_menus/{menu}', 'AdminMenuController@delete')->name('adminmenu.delete');
        });
    });
});
