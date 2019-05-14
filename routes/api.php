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
    // Route::middleware('admin.guard')->prefix('admin')->group(function () {
    Route::middleware('admin.guard')->prefix('admin')->group(function () {
        //管理员登录
        Route::post('/login', 'AdminController@login')->name('admin.login');
        Route::middleware(['jwt.auth', 'admin.permission'])->group(function () {
            //管理员列表
            Route::get('/admins', 'AdminController@index')->name('admin.list');
            //创建管理员
            Route::post('/admins', 'AdminController@store')->name('admin.store');
            Route::put('/admins/{admin}', 'AdminController@update')->name('admin.update');
            //管理员信息
            Route::get('/admins/{admin}', 'AdminController@show')->name('admin.show');
            //删除管理员
            Route::delete('/admins/{admin}', 'AdminController@delete')->name('admin.delete');
            //当前管理员信息
            Route::get('/info', 'AdminController@info')->name('admin.info');
            //管理员退出
            Route::get('/logout', 'AdminController@logout')->name('admin.logout');

            Route::get('/admin_menus', 'AdminMenuController@index')->name('adminmenu.index');
            Route::post('/admin_menus', 'AdminMenuController@store')->name('adminmenu.store');
            Route::put('/admin_menus/{menu}', 'AdminMenuController@update')->name('adminmenu.update');
            Route::delete('/admin_menus/{menu}', 'AdminMenuController@delete')->name('adminmenu.delete');

            Route::get('/admin_permissions', 'AdminPermissionController@index')->name('adminpermission.index');
            Route::get('/admin_permissions/{permission}', 'AdminPermissionController@show')->name('adminpermission.show');
            Route::post('/admin_permissions', 'AdminPermissionController@store')->name('adminpermission.store');
            Route::put('/admin_permissions/{permission}', 'AdminPermissionController@update')->name('adminpermission.update');
            Route::delete('/admin_permissions/{permission}', 'AdminPermissionController@delete')->name('adminpermission.delete');

            Route::get('/admin_roles', 'AdminRoleController@index')->name('adminrole.index');
            Route::get('/admin_roles/{role}', 'AdminRoleController@show')->name('adminrole.show');
            Route::post('/admin_roles', 'AdminRoleController@store')->name('adminrole.store');
            Route::put('/admin_roles/{role}', 'AdminRoleController@update')->name('adminrole.update');
            Route::delete('/admin_roles/{role}', 'AdminRoleController@delete')->name('adminrole.delete');

            Route::get('/categories', 'CategoryController@index')->name('category.index');
            Route::post('/categories', 'CategoryController@store')->name('category.store');
            Route::put('/categories/{category}', 'CategoryController@update')->name('category.update');
            Route::delete('/categories/{category}', 'CategoryController@delete')->name('category.delete');
            Route::put('/categories/{category}/move', 'CategoryController@move')->name('category.move');

            Route::get('/comments', 'CommentController@index')->name('comment.index');
            Route::put('/comments/{comment}/toggle', 'CommentController@toggle')->name('comment.toggle');

            Route::get('/docs', 'DocController@index')->name('doc.index');
            Route::put('/docs/{doc}', 'DocController@update')->name('doc.update');
            Route::get('/docPublishs', 'DocPublishController@index')->name('docPublish.index');
            Route::put('/docPublishs/{docPublish}/review', 'DocPublishController@review')->name('docPublish.review');
            Route::get('/docPublishs/{docPublish}/previewKey', 'DocPublishController@previewKey')->name('docPublish.previewKey');
        });
    });
});
