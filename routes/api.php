<?php

use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\OrganizationController;

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

Route::post('login',[UserController::class, 'login']);
Route::get('profile',[UserController::class, 'getAuthenticatedUser']);
Route::put('profile/update',[ProfilesController::class, 'update']);
Route::post('users/create',[UserController::class, 'createUser']);
Route::get('users/{id}',[UserController::class, 'getUsers']);
Route::delete('users/delete/{id}',[UserController::class, 'delete']);
Route::get('organizations',[OrganizationController::class, 'getOrganizations']);
Route::post('email', [MailController::class, 'sendEmail']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth']], function() {
});

