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
        'middleware' => ['auth', 'verified'],
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
    ],
    function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::get('/profile', 'ProfileController@index')->name('profile.index');
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
        Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::resource('users', 'UsersController');

        Route::resource('categories', 'CategoryController');
        Route::group(
            [
                'prefix' => 'categories',
                'as' => 'categories.',
            ],
            function () {
                Route::post('/{category}/up', 'CategoryController@up')->name('up');
                Route::post('/{category}/down', 'CategoryController@down')->name('down');

                Route::group(['prefix' => '/{category}'], function () {
                    Route::resource('attributes', 'AttributeController')->except('index', 'show');
                });
            }
        );
    }
);

