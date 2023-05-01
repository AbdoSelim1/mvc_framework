<?php

use Src\Http\Routes\Route;
use Src\Http\Request\Request;


Route::get('/', function (Request $request) {
    return view('index');
});
