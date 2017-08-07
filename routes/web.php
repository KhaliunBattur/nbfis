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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'role:admin'], 'as' => 'api.'], function() {

    Route::group(['namespace' => 'User'], function (){
        Route::resource('users', 'UserController', ['except' => ['create']]);
        Route::patch('user/{id}/changePassword', ['as' => 'change.password', 'uses' => 'UserController@changePassword']);

        Route::resource('roles', 'RoleController', ['only' => ['index']]);
        Route::resource('roles.permission', 'PermissionController', ['only' => ['store', 'destroy']]);
        Route::get('permission/search', ['as' => 'permission.search', 'uses' => 'PermissionController@search']);
    });

});
