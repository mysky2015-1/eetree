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

Auth::routes();

Route::get('/', 'DocController@index');
Route::get('/explore', 'DocController@index')->name('explore');
Route::get('/category/{category}', 'CategoryController@index')->name('category.list');
Route::get('/doc/detail/{doc}', 'DocController@detail')->name('doc.detail');
Route::get('/docPublish/preview/{docPublish}', 'DocController@publishPreview')->name('doc.publishPreview');
Route::get('/comments/{doc}', 'CommentController@index')->name('comment.index');

Route::middleware('guest')->group(function () {
    Route::get('password/reset-mobile', 'Auth\ForgotPasswordController@showMobileForm')->name('password.mobile');
    Route::post('/sms/code', 'SmsController@code')->name('sms.code');
    Route::post('password/reset-mobile', 'Auth\ResetPasswordController@resetByMobile')->name('password.resetByMobile');
});

Route::middleware('auth')->group(function () {
    // home
    Route::get('/home', 'HomeController@index')->name('home');
    // doc draft
    Route::post('/draftDocs', 'DocDraftController@store')->name('docDraft.store');
    Route::put('/draftDocs/{docDraft}', 'DocDraftController@save')->name('docDraft.save');
    Route::delete('/draftDocs/{docDraft}', 'DocDraftController@delete')->name('docDraft.delete');
    Route::get('/doc/edit/{docDraft}', 'DocDraftController@edit')->name('docDraft.edit');
    Route::post('/doc/share/{docDraft}', 'DocDraftController@setShare')->name('docDraft.setShare');
    Route::post('/doc/publish/{docDraft}', 'DocDraftController@publish')->name('docDraft.publish');
    Route::get('/doc/share/{docDraft}', 'DocDraftController@share')->name('docDraft.share');
    Route::put('/draftDocs/{docDraft}/move', 'DocDraftController@move')->name('docDraft.move');
    // user category
    Route::post('/folder/{category?}', 'UserCategoryController@folder')->name('userCategory.folder');
    Route::get('/userCategories', 'UserCategoryController@index')->name('userCategory.index');
    Route::post('/categories', 'UserCategoryController@store')->name('userCategory.store');
    Route::put('/categories/{category}', 'UserCategoryController@update')->name('userCategory.update');
    Route::delete('/categories/{category}', 'UserCategoryController@delete')->name('userCategory.delete');
    Route::put('/categories/{category}/move', 'UserCategoryController@move')->name('userCategory.move');

    // upload
    Route::post('/upload/docImage/{docDraft}', 'UploadController@docImage')->name('upload.docImage');

    //comment
    Route::post('/comments/{doc}', 'CommentController@store')->name('comment.store');
});
