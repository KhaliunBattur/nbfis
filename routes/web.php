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

use App\Support\ReferenceText;
use Illuminate\Http\Request;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cv', function() {
    return view('report.cvPDF');
});

Auth::routes();

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'role:admin'], 'as' => 'api.'], function() {

    Route::get('currency/lists', ['as' => 'currency.lists', 'uses' => 'CurrencyController@lists']);
    Route::get('bank/lists', ['as' => 'bank.lists', 'uses' => 'BankController@lists']);

    Route::resource('bank', 'BankController');
    Route::resource('currency', 'CurrencyController');

    Route::resource('branch', 'BranchController');
    Route::get('list/branches', 'BranchController@lists')->name('branch.lists');

    Route::group(['namespace' => 'Account', 'as' => 'account.'], function(){
        Route::resource('account', 'AccountController');
        Route::resource('account/group', 'GroupController', ['except' => ['edit', 'create', 'show', 'update']]);
        Route::get('account/group/{group}/others', ['as' => 'group.others', 'uses' => 'GroupController@others']);
        Route::resource('journal', 'JournalController', ['except' => ['create', 'show', 'edit', 'update']]);
        Route::get('journal/lists', ['as' => 'journal.lists', 'uses' => 'JournalController@lists']);
        Route::get('journal/{id}/group', ['as' => 'journal.lists', 'uses' => 'GroupController@journalGroups']);
    });

    Route::resource('season', 'Season\SeasonController', ['expect' => ['create']]);
    Route::patch('season/{id}/balance', ['as' => 'season.balance.save', 'uses' => 'Season\SeasonController@saveBalance']);

    Route::group(['namespace' => 'User'], function (){
        Route::resource('users', 'UserController', ['except' => ['create']]);
        Route::patch('user/{id}/changePassword', ['as' => 'change.password', 'uses' => 'UserController@changePassword']);
        Route::patch('user/{id}/saveLiveYear', ['as' => 'change.save.live.year', 'uses' => 'UserController@saveLiveYear']);
        Route::patch('user/{id}/saveOwnerType', ['as' => 'change.save.owner.type', 'uses' => 'UserController@saveOwnerType']);
        Route::patch('user/{id}/saveAddress', ['as' => 'change.save.address', 'uses' => 'UserController@saveAddress']);

        Route::get('user/{id}/info', ['as' => 'user.info', 'uses' => 'UserController@info']);

        Route::get('user/{register}','UserController@findByRegister');

        Route::resource('cv', 'CvController', ['except' => ['create']]);
        Route::post('cv/filesUpload','CvController@fileUpload');
        Route::post('cv/profileUpload','CvController@profileUpload');

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

        Route::get('user/{id}/budget', ['as' => 'user.budget.index', 'uses' => 'BudgetController@index']);
        Route::post('user/{id}/budget', ['as' => 'user.budget.store', 'uses' => 'BudgetController@store']);
        Route::patch('user/{id}/budget/{budget}', ['as' => 'user.budget.update', 'uses' => 'BudgetController@update']);
        Route::delete('user/{id}/budget/{budget}/destroy', ['as' => 'user.budget.destroy', 'uses' => 'BudgetController@destroy']);

        Route::get('user/{id}/expense', ['as' => 'user.expense.index', 'uses' => 'ExpenseController@index']);
        Route::post('user/{id}/expense', ['as' => 'user.expense.store', 'uses' => 'ExpenseController@store']);
        Route::patch('user/{id}/expense/{expense}', ['as' => 'user.expense.update', 'uses' => 'ExpenseController@update']);
        Route::delete('user/{id}/expense/{expense}/destroy', ['as' => 'user.expense.destroy', 'uses' => 'ExpenseController@destroy']);

        Route::get('user/{id}/asset', ['as' => 'user.asset.index', 'uses' => 'AssetController@index']);
        Route::post('user/{id}/asset', ['as' => 'user.asset.store', 'uses' => 'AssetController@store']);
        Route::patch('user/{id}/asset/{asset}', ['as' => 'user.asset.update', 'uses' => 'AssetController@update']);
        Route::delete('user/{id}/asset/{asset}/destroy', ['as' => 'user.asset.destroy', 'uses' => 'AssetController@destroy']);

        Route::resource('roles', 'RoleController', ['only' => ['index']]);
        Route::resource('roles.permission', 'PermissionController', ['only' => ['store', 'destroy']]);
        Route::get('permission/search', ['as' => 'permission.search', 'uses' => 'PermissionController@search']);

        Route::get('customer/list', 'UserController@customerList')->name('customer.list');
        Route::get('user/list', 'UserController@userList')->name('user.list');
    });

    Route::get('relations', function(){
        return response()->json([
            'relations' => \Config::get('enums.relation')
        ]);
    });

    Route::get('advertisements', function(){
        return response()->json([
            'advertisements' => \Config::get('enums.advertisement')
        ]);
    });

    Route::get('owner_types', function(){
        return response()->json([
            'owner_types' => \Config::get('enums.owner_type')
        ]);
    });

    Route::get('pledge_types', function(){
        return response()->json([
            'pledge_types' => \Config::get('enums.pledge_type')
        ]);
    });

    Route::get('codes', function(){
        return response()->json([
            'codes' => \Config::get('enums.codes')
        ]);
    });

    Route::get('references/{type}', function ($type, Request $request){
        return ReferenceText::where('type', $type)
            ->where('text','like', '%' . $request->get('term') . '%')
            ->pluck('text');
    });

});