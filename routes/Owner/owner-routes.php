<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Owner\OwnerController;
use App\Http\Controllers\Api\Owner\OwnerAuthController;
use App\Http\Controllers\BookingController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\hallResource;


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

    Route::group(['namespace'=>'Owner'],function (){
        Route::post('loginOwner', [OwnerAuthController::class, 'login'])->name('login-Owner');
        Route::post('logoutOwner',[ OwnerAuthController::class,'logout'])-> middleware(['auth.guard:owner-api']);
        Route::post('registerOwner', [OwnerAuthController::class, 'registerOwner']);
        Route::post('updateOwner', [OwnerAuthController::class, 'updateOwner']);
        Route::get('profileOfOwner', [OwnerAuthController::class, 'userProfile']);
            });
});
Route::group([
    'middleware' => ['api'],
    'namespace'=>'Api',

], function ($router) {        // Hall
        Route::post('/addHallRequest', [OwnerController::class, 'addHallRequests']);
        Route::get('/DestroyAllHallRequest', [OwnerController::class, 'DestroyAllHallRequest']);
        Route::get('destroyHallRequest/{request_id}', [OwnerAuthController::class, 'destroyHallRequest']);
        Route::get('ownerphoto/{user_id}', [OwnerAuthController::class, 'getOwnerPhoto']);
        Route::post('updateAllInfoOfHallRequest/{user_id}', [OwnerController::class, 'updateAllInfoOfHallRequest']);


        // Bookings
/*         Route::apiResource('bookings', 'BookingsApiController');
 */        Route::post('/bookings', [BookingController::class, 'bookRoom']);
           Route::post('/avl', [BookingController::class, 'getAvailableHalls']);
           Route::get('/viewBookings', [BookingController::class, 'viewBookings']);

           Route::post('/bookings/{bookingId}/confirm', [BookingController::class, 'confirmBooking']);
           Route::post('/bookings/{bookingId}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
           Route::delete('/bookings/rejected', [BookingController::class, 'destroyRejectedBookings']);
});




