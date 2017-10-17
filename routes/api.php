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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    // driver routes
    Route::group(['prefix' => 'driver', 'middleware' => 'jwt.auth', 'jwt.refresh'], function () {
        Route::post('new-trip', 'UserController@new_trip');
    });

    Route::group(['prefix' => 'guest'], function () {
        Route::get('drivers/monopolists', 'UserController@getMonopolists');
        Route::post('authenticate', 'Auth\AuthenticateController@authenticate');
        Route::post('register', 'Auth\AuthenticateController@register');
    });

});
