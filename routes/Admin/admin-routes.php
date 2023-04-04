<?php

/* use App\Http\Controllers\AuthController; */
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\AuthController as UserAuthController;
use App\Http\Controllers\hallsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
    'namespace'=>'Api',

], function ($router) {

    Route::group(['namespace'=>'Admin'],function (){
        Route::post('login', [AuthController::class, 'login'])->name('login-admin');
        Route::post('logout',[ AuthController::class,'logout'])-> middleware(['auth.guard:admin-api']);


        // Hall
        Route::apiResource('Hall', 'HallApiController');

        // Bookings
        Route::apiResource('bookings', 'BookingsApiController');

            });






    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});








