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
        Route::patch('user/{id}/saveLiveYear', ['as' => 'change.save.live.year', 'uses' => 'UserController@saveLiveYear']);
        Route::patch('user/{id}/saveOwnerType', ['as' => 'change.save.owner.type', 'uses' => 'UserController@saveOwnerType']);
        Route::patch('user/{id}/saveAddress', ['as' => 'change.save.address', 'uses' => 'UserController@saveAddress']);

        Route::get('user/{id}/family', ['as' => 'user.family.index', 'uses' => 'FamilyController@index']);
        Route::post('user/{id}/family', ['as' => 'user.family.store', 'uses' => 'FamilyController@store']);
        Route::patch('user/{id}/family/{family}', ['as' => 'user.family.update', 'uses' => 'FamilyController@update']);
        Route::delete('user/{id}/family/{family}/destroy', ['as' => 'user.family.destroy', 'uses' => 'FamilyController@destroy']);

        Route::get('user/{id}/workplace', ['as' => 'user.workplace.index', 'uses' => 'WorkplaceController@index']);
        Route::post('user/{id}/workplace', ['as' => 'user.workplace.store', 'uses' => 'WorkplaceController@store']);
        Route::patch('user/{id}/workplace/{workplace}', ['as' => 'user.workplace.update', 'uses' => 'WorkplaceController@update']);
        Route::delete('user/{id}/workplace/{workplace}/destroy', ['as' => 'user.workplace.destroy', 'uses' => 'WorkplaceController@destroy']);

        Route::get('user/{id}/emergency', ['as' => 'user.emergency.index', 'uses' => 'ContactController@index']);
        Route::post('user/{id}/emergency', ['as' => 'user.emergency.store', 'uses' => 'ContactController@store']);
        Route::patch('user/{id}/emergency/{emergency}', ['as' => 'user.emergency.update', 'uses' => 'ContactController@update']);
        Route::delete('user/{id}/emergency/{emergency}/destroy', ['as' => 'user.emergency.destroy', 'uses' => 'ContactController@destroy']);
        //credit route
        Route::get('user/{id}/credit', ['as' => 'user.credit.index', 'uses' => 'CreditController@index']);
        Route::post('user/{id}/credit', ['as' => 'user.credit.store', 'uses' => 'CreditController@store']);
        Route::patch('user/{id}/credit/{credit}', ['as' => 'user.credit.update', 'uses' => 'CreditController@update']);
        Route::delete('user/{id}/credit/{credit}/destroy', ['as' => 'user.credit.destroy', 'uses' => 'CreditController@destroy']);

        Route::resource('roles', 'RoleController', ['only' => ['index']]);
        Route::resource('roles.permission', 'PermissionController', ['only' => ['store', 'destroy']]);
        Route::get('permission/search', ['as' => 'permission.search', 'uses' => 'PermissionController@search']);
    });

    Route::get('relations', function(){
        return response()->json([
            'relations' => \Config::get('enums.relation')
        ]);
    });

});
