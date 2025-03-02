<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function () {
    return 123;
});
