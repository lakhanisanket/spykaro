<?php

use App\Http\Controllers\Api\V1\Admin\AccessControlApiController;
use App\Http\Controllers\Api\V1\Admin\DeviceApiController;
use App\Http\Controllers\Api\V1\Admin\FeedbackApiController;
use App\Http\Controllers\Api\V1\Admin\TrackingApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Api\V1\Admin\UserOptionApiController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    // Users
    Route::post('sendOtp', [UserApiController::class, 'sendOtp']);
    Route::post('login', [UserApiController::class, 'login']);
    Route::post('userGet', [UserApiController::class, 'userGet']);

});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {

    // Profile update
    Route::post('profileUpdate', [UserApiController::class, 'profileUpdate']);

    // Tracking
    Route::post('getTracking', [TrackingApiController::class, 'getTracking']);
    Route::post('addTracking', [TrackingApiController::class, 'addTracking']);
    Route::post('updateTracking', [TrackingApiController::class, 'updateTracking']);
    Route::post('deleteTracking', [TrackingApiController::class, 'deleteTracking']);

    // Device
    Route::post('getDevice', [DeviceApiController::class, 'getDevice']);
    Route::post('addDevice', [DeviceApiController::class, 'addDevice']);
    Route::post('updateDevice', [DeviceApiController::class, 'updateDevice']);
    Route::post('deleteDevice', [DeviceApiController::class, 'deleteDevice']);

    // User-Options
    Route::post('getOptions', [UserOptionApiController::class, 'getOptions']);
    Route::post('addEditOption', [UserOptionApiController::class, 'addEditOption']);
    Route::post('deleteOption', [UserOptionApiController::class, 'deleteOption']);

    // Access Control
    Route::post('getAccessControl', [AccessControlApiController::class, 'getAccessControl']);
    Route::post('addAccessControl', [AccessControlApiController::class, 'addAccessControl']);
    Route::post('editAccessControl', [AccessControlApiController::class, 'editAccessControl']);
    Route::post('deleteAccessControl', [AccessControlApiController::class, 'deleteAccessControl']);

    // Feedback
    Route::post('addFeedback', [FeedbackApiController::class, 'addFeedback']);

});
