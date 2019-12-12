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

#Auth::routes();
Route::get('/login', 'LoginController@index')->name('login.index');
Route::post('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::get('/register', 'LoginController@create')->name('register');
Route::post('/register', 'LoginController@store')->name('register.post');


// Auth::logout();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'BbsController@index')->name('home');
    Route::post('/post', 'BbsController@store')->name('bbs.store');
    Route::get('/admin', 'BbsController@adminindex')->name('admin');
    Route::post('/admin', 'BbsController@adminpost')->name('admin.post');
    Route::get('/admin/delete', 'BbsController@admindelete')->name('admin.delete');
    // Route::get('/admin', 'BbsController@adminindex')->name('admin');

    Route::get('/users', 'UserSearchController@index')->name('search.index');
    Route::get('/users/s/{s?}', 'UserSearchController@post')->name('search.post');
    // Route::get('/user/{id?}')
});
