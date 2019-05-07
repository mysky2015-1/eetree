<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('password/reset-mobile', 'Auth\ForgotPasswordController@showMobileForm')->name('password.mobile');
    Route::post('/sms/code', 'SmsController@code')->name('sms.code');
    Route::post('password/reset-mobile', 'Auth\ResetPasswordController@resetByMobile')->name('password.resetByMobile');
});

Route::middleware('auth')->group(function () {
    // doc draft
    Route::get('/doc/new', 'DocDraftController@edit')->name('docDraft.new');
    Route::get('/doc/edit/{docDraft}', 'DocDraftController@edit')->name('docDraft.edit');
    Route::post('/doc/save/{docDraft?}', 'DocDraftController@save')->name('docDraft.save');
    // user category
    Route::post('/folder', 'CategoryController@folder')->name('userCategory.folder');
    Route::post('/categories', 'CategoryController@store')->name('userCategory.store');
    Route::put('/categories/{category}', 'CategoryController@update')->name('userCategory.update');
    // doc
    Route::get('/doc/list', 'DocController@index')->name('doc.index');
    Route::get('/doc/detail/{doc}', 'DocController@detail')->name('doc.detail');
    Route::get('/doc/search', 'DocController@search')->name('doc.search');
});
