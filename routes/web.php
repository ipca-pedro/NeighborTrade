<?php

use Illuminate\Support\Facades\Route;

// Rota padrão que servirá o aplicativo React
Route::get('/{path?}', function () {
    return view('app');
})->where('path', '.*');
