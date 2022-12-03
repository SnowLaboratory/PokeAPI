<?php

use App\Http\Controllers\Admin\SpeciesController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\GenerationController;
use App\Http\Controllers\GlueController;
use App\Http\Controllers\GuestController;
use App\Http\Resources\SpeciesDetailResource;
use App\Http\Resources\SpeciesResource;
use App\Models\Species;
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

Route::get('/glue', [GlueController::class, 'create']);
Route::post('/glue/names', [GlueController::class, 'names'])->name('glue.names');
Route::post('/glue/fetch', [GlueController::class, 'fetch'])->name('glue.fetch');
Route::post('/glue/save', [GlueController::class, 'save'])->name('glue.save');


Route::resource('species', SpeciesController::class);
