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

use App\Http\Controllers\Api;

Route::post('auth/login', [Api\AuthController::class, 'login']);
Route::post('auth/logout', [Api\AuthController::class, 'logout']);

Route::group(['middleware' => ['auth.jwt', 'auth.acl']], function () {
    Route::apiResource('users', Api\UserController::class);
    Route::apiResource('roles', Api\RoleController::class);
    Route::apiResource('actions', Api\ActionController::class);
    Route::apiResource('modules', Api\ModuleController::class);
    Route::apiResource('permissions', Api\PermissionController::class);
});
