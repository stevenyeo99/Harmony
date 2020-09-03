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

// manage user module
Route::prefix('/manage_user')->group(function() {
    Route::get('/profile', 'HsUserController@getProfile')->name('manage.user.profile');
    Route::post('/save_profile', 'HsUserController@saveProfile')->name('manage.user.save_profile');

    // manage admin route
    Route::group(['middleware' => 'can:is-admin'], function() {
        Route::get('/', 'HsUserController@index')->name('manage.user');
        Route::get('/list', 'HsUserController@displayData')->name('manage.user.list');
        Route::get('/create', 'HsUserController@create')->name('manage.user.create');
        Route::post('/create', 'HsUserController@store')->name('manage.user.store');
        Route::get('/view/{id}', 'HsUserController@view')->name('manage.user.view');
    });
});

// manage item module

// manage supplier module

// manage purchase module

// manage invoice module

// home routing
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gettingJsonSellBuyView', 'HomeController@gettingJsonSellBuyView');