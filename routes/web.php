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

Auth::routes(['verify' => true]);

Route::group(
    [
        'middleware' => ['auth', 'verified']
    ],
    function () {
        Route::get('/home', 'HomeController@index')->name('home');
    }
);

Route::group(
    [
        'middleware' => ['auth', 'verified'],
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');

        Route::get('/users', 'UsersController@index')->name('users');
        Route::get('/users/{id]', 'UsersController@show')->name('users.show');

    }
);

