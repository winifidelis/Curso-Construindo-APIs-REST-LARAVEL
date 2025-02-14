<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Products;

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

Route::get('/test', function(Request $request) {
    //dd($request->headers->all());
    //dd($request->headers->get('nada'));
    $response = new \Illuminate\Http\Response(json_encode(['msg' => 'minha primeira resposta de API']));
    $response->header('Content-Type', 'application/json');
    return $response;
});

//Products Route
//Route::get('/products', function(){
//    return Products::all();
//});
Route::namespace('Api')->group(function() {
    //Products route
    Route::prefix('products')->group(function(){
        Route::get('/', 'ProductController@index');
        Route::get('/{id}', 'ProductController@show');
        Route::post('/', 'ProductController@save');//->middleware('auth.basic');
        Route::put('/', 'ProductController@update');
        Route::delete('/{id}', 'ProductController@delete');
    });
    
    Route::resource('/users', 'UserController');
});
