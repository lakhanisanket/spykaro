<?php

use App\Http\Controllers\Api\V1\Admin\UserApiController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    // Users
    Route::get('getOtp', [UserApiController::class, 'getOtp']);

});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {

});
