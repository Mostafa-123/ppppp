<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Planner\PlannerAuthController ;
use App\Http\Controllers\hallsController;
use App\Models\PlannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\responseTrait;
Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
    'namespace'=>'Api',

], function ($router) {
    Route::group(['namespace'=>'Planner',],function (){
            Route::post('loginPlanner', [PlannerAuthController::class, 'login'])->name('login-Planner');
            Route::post('registerPlanner', [PlannerAuthController::class, 'registerPlanner']);
            Route::get('profilePlanner', [PlannerAuthController::class, 'userProfile']);
            Route::post('updatePlanner', [PlannerAuthController::class, 'updatePlanner']);
            Route::post('logoutPlanner',[ PlannerAuthController::class,'logout'])-> middleware(['auth.guard:planner-api']);
                });


        });
Route::group([
    'middleware' => ['api'],
    'namespace' => 'Api',

], function ($router) {
    Route::group(['namespace' => 'Planner',], function () {
        Route::get('plannerphoto/{user_id}', [PlannerAuthController::class, 'getPlannerPhoto']);
        Route::post('addPlan', [PlannerController::class, 'addPlan']);
        Route::get('planphoto/{user_id}', [PlannerController::class, 'getPlanPhoto']);
        Route::post('/deletePlan/{id}', [PlannerController::class, 'deletePlan']);
        Route::post('/updatePlan/{id}', [PlannerController::class, 'updatePlan']);
        Route::post('addPhotoToMyplan/{plan_Id}', [PlannerController::class, 'addPhotoToMyplan']);
        Route::get('viewConfirmedBookingsPlans', [PlannerController::class, 'viewConfirmedBookingsPlans']);
        Route::get('viewCancelledBookingsPlans', [PlannerController::class, 'viewCancelledBookingsPlans']);
        Route::get('viewBookingsplans', [PlannerController::class, 'viewBookingsplans']);
        Route::post('confirmBookingPlan/{bookingplanId}', [PlannerController::class, 'confirmBookingPlan']);
        Route::post('rejectBooking/{bookingplanId}', [PlannerController::class, 'rejectBooking']);

    });
});

Route::any('{url}',function (){
    return $this->response("","this url not found",401);
})->where('url','.*')->middleware('api');
