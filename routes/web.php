<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {

    // Route::get('login/plex/{id}', 'autoLogin');
    // Route::get('login/callback', 'handlePlexCallback');
    // Route::match(['get', 'post'], 'logout/{redirect_url?}', 'logout')->name('logout');

    // Replace filament logout
    // Route::post('logout', 'logout')->name('filament.auth.logout');

});

