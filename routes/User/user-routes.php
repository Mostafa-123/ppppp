<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\UserAuthController;
use App\Http\Controllers\hallsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
    'namespace'=>'Api',

], function ($router) {
    Route::group(['namespace'=>'User',],function (){
            Route::post('login', [UserAuthController::class, 'login'])->name('login-user');
            Route::post('logout',[ UserAuthController::class,'logout'])-> middleware(['auth.guard:user-api']);

                });


        });
