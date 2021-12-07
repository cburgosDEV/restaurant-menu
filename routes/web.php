<?php

use Illuminate\Support\Facades\Route;

//LOGIN AND LOGOUT
Route::get('login', ['App\Http\Controllers\Auth\LoginController', 'showLoginForm'])->name('login');
Route::post('login', ['App\Http\Controllers\Auth\LoginController', 'login']);
Route::get('logout', ['App\Http\Controllers\Auth\LoginController', 'logout'])->name('logout');
Route::post('logout', ['App\Http\Controllers\Auth\LoginController', 'logout']);

//ALL ROUTES
Route::group(['middleware'=>['auth']], function ()
{
    //INDEX
    Route::prefix('')->group(function ()
    {
        Route::get('/', ['App\Http\Controllers\HomeController', 'index']);
    });

    //USER
    Route::prefix('user')->group(function () {
        Route::get('', ['App\Http\Controllers\UserController', 'index']);
        Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\UserController', 'jsonIndex']);
        Route::get('jsonCreate', ['App\Http\Controllers\UserController', 'jsonCreate']);
        Route::post('store', ['App\Http\Controllers\UserController', 'store']);
        Route::get('jsonDetail/{idCategory}', ['App\Http\Controllers\UserController', 'jsonDetail']);
        Route::post('changePassword', ['App\Http\Controllers\UserController', 'changePassword']);
    });
});
