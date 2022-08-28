<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\GenerationController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/gen')->group(function (){
    Route::get('/', function() {
        return view ('gen');
    });
    Route::get('/kanto', [GenerationController::class, 'getGeneration']);
    Route::get('/{gen}', [GenerationController::class, 'getGeneration']);

});


Route::get('/national-dex', [ExampleController::class, 'getNationalDex']);

Route::get('/about', function () {
    return view('about');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//require __DIR__.'/auth.php';
