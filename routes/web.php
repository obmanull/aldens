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
        'middleware' => ['auth', 'verified', 'can:admin-panel'],
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
    ],
    function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('users', 'UsersController');
        Route::resource('/categories', 'CategoryController');
        Route::post('/categories/{category}/up', 'CategoryController@up')->name('categories.up');
        Route::post('/categories/{category}/down', 'CategoryController@down')->name('categories.down');
    }
);

