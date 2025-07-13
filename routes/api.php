<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{LoginController,
                         HomeController,
                         KpisController};


Route::get('/whoami', function (Request $request) {
    return \Auth::user();
})->middleware('auth:sanctum');

Route::controller(LoginController::class)
->prefix('/login')
->group(function(){
    Route::post('/', 'doLogin');
});

Route::controller(HomeController::class)
->prefix('/home')
->group(function(){
    Route::get('/users', 'searchUsers');
})->middleware('auth:sanctum');


Route::controller(KpisController::class)
->prefix('/kpis')
->group(function(){
    Route::get( '/types', 'getTypes');
    Route::get('/', 'search');
    Route::post('/', 'create');
    Route::get('/{id}', 'getItem');
    Route::put('/{id}', 'update');
})->middleware('auth:sanctum');
