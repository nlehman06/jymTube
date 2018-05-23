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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/addVideo', 'VideoController@create')->middleware('auth')->name('addVideo');

Route::post('/api/addVideo/checkURL', 'VideoController@checkURL')->name('checkURL');
Route::post('/api/addVideo', 'VideoController@store')->name('storeVideoForReview');

Route::get('/api/getAccount', 'HomeController@getAccount');

Route::get('register-email', 'RegisterEmailController@edit')->name('register.email.edit');
Route::post('register-email', 'RegisterEmailController@store')->name('register.email.store');
Route::get('resend', 'RegisterEmailController@resend')->name('register.email.resend');
Route::get('congrats', 'RegisterEmailController@congrats')->name('activate.congrats');
Route::get('rememberToActivate', 'RegisterEmailController@rememberToActivate')->name('activate.reminder');

Route::get('verify-user/{code}', 'RegisterEmailController@activateUser')->name('activate.user');

// OAuth Routes
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('users', 'UserController@index')->name('users.index');
Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
Route::patch('users/{user}', 'UserController@update')->name('users.update');

Route::get('roles', 'RoleController@index')->name('roles.index');

Route::get('permissions', 'PermissionController@index')->name('permissions.index');
Route::get('permissions/create', 'PermissionController@create')->name('permissions.create');
Route::get('permissions/{permission}/edit', 'PermissionController@edit')->name('permissions.edit');
Route::delete('permissions/{permission}', 'PermissionController@destroy')->name('permissions.destroy');
Route::post('permissions', 'PermissionController@store')->name('permissions.store');
Route::patch('permissions/{permission}', 'PermissionController@update')->name('permissions.update');

Route::resource('roles', 'RoleController');
