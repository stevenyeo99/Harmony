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
// Route::get('/aw', function() {
// 	return Hash::make('suzybae8');
// });
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routing
// disabled register route
Auth::routes(['register' => false]);
// prevent error while run logout url
Route::get('/logout', function() {
    return back();
});

// user profile routing
Route::get('/profile', 'HsUserController@getProfile')->name('user.profile');
Route::post('/save_profile', 'HsUserController@saveProfile')->name('user.save_profile');

// home routing
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gettingJsonSellBuyView', 'HomeController@gettingJsonSellBuyView');