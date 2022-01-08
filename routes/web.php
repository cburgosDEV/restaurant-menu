<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

//LOGIN AND LOGOUT
Route::get('login', ['App\Http\Controllers\Auth\LoginController', 'showLoginForm'])->name('login');
Route::post('login', ['App\Http\Controllers\Auth\LoginController', 'login']);
Route::get('logout', ['App\Http\Controllers\Auth\LoginController', 'logout'])->name('logout');
Route::post('logout', ['App\Http\Controllers\Auth\LoginController', 'logout']);

//ALL ROUTES
Route::group(['middleware'=>['auth']], function ()
{
    //HOME
    Route::prefix('')->group(function ()
    {
        Route::get('/', ['App\Http\Controllers\HomeController', 'index']);
        Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\HomeController', 'jsonIndex'])->middleware('role:super');
    });

    //HOME USER
    Route::prefix('homeUser')->middleware('role:admin|super')->group(function ()
    {
        Route::get('/{idUser?}', ['App\Http\Controllers\HomeUserController', 'index']);
        Route::get('jsonIndex/{idUser?}/{filterText?}', ['App\Http\Controllers\HomeUserController', 'jsonIndex']);
    });

    //USER
    Route::prefix('user')->middleware('role:super')->group(function () {
        Route::get('', ['App\Http\Controllers\UserController', 'index']);
        Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\UserController', 'jsonIndex']);
        Route::get('jsonCreate', ['App\Http\Controllers\UserController', 'jsonCreate']);
        Route::post('store', ['App\Http\Controllers\UserController', 'store']);
        Route::get('jsonDetail/{id}', ['App\Http\Controllers\UserController', 'jsonDetail']);
        Route::post('changePassword', ['App\Http\Controllers\UserController', 'changePassword']);
    });

    //RESTAURANT
    Route::prefix('restaurant')->middleware('role:admin|super')->group(function ()
    {
        //Route::get('/', ['App\Http\Controllers\RestaurantController', 'index']);
        //Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\RestaurantController', 'jsonIndex']);
        Route::get('create/{idUser?}', ['App\Http\Controllers\RestaurantController', 'create']);
        Route::get('jsonCreate', ['App\Http\Controllers\RestaurantController', 'jsonCreate']);
        Route::post('store', ['App\Http\Controllers\RestaurantController', 'store']);
        Route::get('update/{id}', ['App\Http\Controllers\RestaurantController', 'update']);
        Route::get('jsonUpdate/{id}', ['App\Http\Controllers\RestaurantController', 'jsonUpdate']);
        Route::post('softDelete', ['App\Http\Controllers\RestaurantController', 'softDelete']);
    });

    //CATEGORY
    Route::prefix('category')->middleware('role:super')->group(function () {
        Route::get('{discriminator?}', ['App\Http\Controllers\CategoryController', 'index']);
        Route::get('jsonIndex/{discriminator}/{filterText?}', ['App\Http\Controllers\CategoryController', 'jsonIndex']);
        Route::get('jsonCreate/{discriminator?}', ['App\Http\Controllers\CategoryController', 'jsonCreate']);
        Route::post('store', ['App\Http\Controllers\CategoryController', 'store']);
        Route::get('jsonDetail/{id}', ['App\Http\Controllers\CategoryController', 'jsonDetail']);
    });

    //PLATE
    Route::prefix('plate')->middleware('role:admin|super')->group(function () {
        Route::get('{idRestaurant?}', ['App\Http\Controllers\PlateController', 'index']);
        Route::get('jsonIndex/{idRestaurant}/{filterText?}', ['App\Http\Controllers\PlateController', 'jsonIndex']);
        Route::get('jsonIndexPlate/{idPlate}/{filterText?}', ['App\Http\Controllers\PlateController', 'jsonIndexPlate']);
        Route::get('jsonCreate/{idPlate?}', ['App\Http\Controllers\PlateController', 'jsonCreate']);
        Route::post('store', ['App\Http\Controllers\PlateController', 'store']);
        Route::get('jsonDetail/{idPlate}', ['App\Http\Controllers\PlateController', 'jsonDetail']);

        Route::get('jsonCreateCategory/{discriminator?}', ['App\Http\Controllers\CategoryController', 'jsonCreate']);
        Route::post('storeCategory', ['App\Http\Controllers\CategoryController', 'store']);
        Route::get('jsonDetailCategory/{idCategory}', ['App\Http\Controllers\CategoryController', 'jsonDetail']);
    });

    //PROFILE
    Route::prefix('profile')->middleware('role:admin|super')->group(function () {
        Route::get('', ['App\Http\Controllers\ProfileController', 'index']);
        Route::get('jsonIndex', ['App\Http\Controllers\ProfileController', 'jsonIndex']);
        Route::post('store', ['App\Http\Controllers\ProfileController', 'store']);
        Route::post('changePassword', ['App\Http\Controllers\ProfileController', 'changePassword']);
    });
});
