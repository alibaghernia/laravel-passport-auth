<?php

use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {

    Route::post('register', 'API\Auth\RegisterController@signup');
    Route::post('login', 'API\Auth\LoginController@login');

    Route::get('register/activate/{token}', 'API\Auth\AuthController@signupActivate');

    // Authorized Routes API
    Route::middleware(["auth:api"], EnsureEmailIsVerified::class)->group(function () {

        Route::get('profile', 'API\Auth\ProfileController@index');
        Route::get('logout', 'API\Auth\LogoutController@index');
    });
});
