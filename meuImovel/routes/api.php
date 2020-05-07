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

Route::prefix('v1')->namespace('Api')->group(function () {

    Route::post('login','Auth\\LoginJwtController@login')->name('login');
    Route::get('logout','Auth\\LoginJwtController@logout')->name('logout');
    Route::get('refresh','Auth\\LoginJwtController@refresh')->name('refresh');

    //estou criando as rotas aqui para facilitar a minha vida mesmo
    //pois abaixo estou com uma altenticação funcionando
    Route::get('/search', 'RealStateSearchController@index')->name('search');

    Route::group(['middleware' => ['jwt.auth']], function(){
        Route::name('real_states.')->group(function () {
            Route::resource('real-states', 'RealStateController'); //api/v1/real-states
        });
        Route::name('users.')->group(function () {
            Route::resource('users', 'UserController'); //api/v1/users
        });
        Route::name('categories.')->group(function () {
            Route::get('categories/{id}/real-states', 'CategoryController@realStates');
            Route::resource('categories', 'CategoryController'); //api/v1/categories
        });
        Route::name('photos.')->prefix('photos')->group(function () {
            Route::delete('/{id}', 'RealStatePhotoController@remove')->name('delete');
            Route::put('/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->name('delete');
        });
    });
});
