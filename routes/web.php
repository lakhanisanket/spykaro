<?php

use App\Filament\Resources\UserResource;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('https://spykaro.com/admin');
});

Route::group(['prefix' => 'v1'], function () {

    Route::post('sendOtp', [UserResource::class, 'sendOtp']);
    Route::post('login', [UserResource::class, 'login']);
});
