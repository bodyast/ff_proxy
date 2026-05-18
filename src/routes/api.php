<?php

use Illuminate\Support\Facades\Route;
use Formflex\Proxy\Http\Controllers\FormProxyController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('v1/form_flex/proxy')->group(function () {
        Route::get('/forms/{id}', [FormProxyController::class, 'show']);
    });
});
