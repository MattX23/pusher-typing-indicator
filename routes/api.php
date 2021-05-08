<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api'], function() {
    Route::post('/message/send', 'MessageController@send');
});
