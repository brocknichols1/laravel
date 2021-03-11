<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard',[TasksController::class, 'index'])->name('dashboard');

    Route::get('/task',[App\Http\Controllers\TasksController::class, 'add']);
    Route::post('/task',[App\Http\Controllers\TasksController::class, 'create']);
    
    Route::get('/task/{task}', [App\Http\Controllers\TasksController::class, 'edit']);
    Route::post('/task/{task}', [App\Http\Controllers\TasksController::class, 'update']);
});
