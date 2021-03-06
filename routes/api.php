<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/api/login', 'ApiController@login');

Route::group(['middleware' => 'auth:api'], function() {

    # GET User.
    Route::get('/user', 'ApiController@user');

    # GET Transactions
    Route::get('transactions', 'ActivityController@get');

    # POST Save new transaction item.
    Route::post('transactions', 'ActivityController@store');

    # DELETE Transaction
    Route::delete('transactions/destroy', 'ApiController@destroyTransaction');

    # GET Budget
    Route::get('budget', 'BudgetController@get');

    # POST Create New Category
    Route::post('budget', 'ApiController@storeCategory');

    # POST Create new Pending transaction
    Route::post('transactions/pending', 'ActivityController@store');

    # GET Pending Transactions
    Route::get('transactions/pending', 'ActivityController@get');
});

