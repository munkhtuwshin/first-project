<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class,'index']);

Route::get("/post/datalist", [PostController::class, 'dataTable']);

Route::resource('/post', PostController::class);
// dataTable

