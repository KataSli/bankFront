<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/diamond/login','ClientController@loginUser');
Route::get('/diamond/login','ClientController@loginUser');


Route::post('/diamond/getAccounts','ClientAccountController@getAccounts');
Route::get('/diamond/getAccounts','ClientAccountController@getAccounts');


Route::post('/diamond/calculateAccountNumber','AccountController@calculateAccountNumberReq');

Route::post('/diamond/newestTransfers','TransferController@getNewestTransfers');
Route::post('/diamond/transferHistory','TransferController@getTransfers');
Route::get('/diamond/internalTransfer','TransferController@internalTransfer');
Route::post('/diamond/internalTransfer','TransferController@internalTransfer');
Route::post('/diamond/sendXML','TransferController@sendFiles');
