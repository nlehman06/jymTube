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
