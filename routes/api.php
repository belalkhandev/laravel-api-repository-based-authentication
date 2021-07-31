<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
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

Route::group([
    'prefix' => 'user',
    'middleware' => 'cors'
], function ($route) {
    $route->post('register', [AuthController::class, 'register']);
    $route->post('login', [AuthController::class, 'login']);
});

Route::group([
    'prefix' => 'user',
    'middleware' => ['cors', 'auth:api']
], function ($route) {
    $route->get('me', [UsersController::class, 'me']);
    $route->get('list', [UsersController::class, 'users']);
    $route->post('logout', [AuthController::class, 'logout']);
});
