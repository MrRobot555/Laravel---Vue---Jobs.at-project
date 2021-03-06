<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [HomeController::class, 'index']);

// Route::get('/jobs', [JobController::class, 'create']);
// Route::post('/jobs', [JobController::class, 'store']);

// Route::get('/admin', fn () => view('user.admin'));

Route::get('{any}', function () {
    return view('layout');
})->where('any', '.*');