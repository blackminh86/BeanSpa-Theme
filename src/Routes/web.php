<?php

use Illuminate\Support\Facades\Route;

Route::get('/beanspa-demo', function () {
    return response()->file(__DIR__.'/../Resources/views/index.html');
})->name('beanspa.demo');
