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
Route::post('auth/register', [Api\AuthController::class, 'register']);

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::post('auth/logout', [Api\AuthController::class, 'logout']);
    Route::post('users/permitted', [Api\UserController::class, 'hasPermission']);
    Route::post('roles/permitted', [Api\RoleController::class, 'rolePermissions']);
});

Route::group(['middleware' => ['auth.jwt', 'auth.acl']], function () {
    Route::post('roles/permissions/attach', [Api\RoleController::class, 'attach']);
    Route::post('roles/permissions/detach', [Api\RoleController::class, 'detach']);
    Route::apiResource('users', Api\UserController::class);
    Route::apiResource('roles', Api\RoleController::class);
    Route::apiResource('actions', Api\ActionController::class);
    Route::apiResource('modules', Api\ModuleController::class);
    Route::apiResource('permissions', Api\PermissionController::class);
});

