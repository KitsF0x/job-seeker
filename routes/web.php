<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\RequirementController;

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

Route::resource('jobOffer', JobOfferController::class);

Route::post('/requirement/{jobOffer}', [RequirementController::class, 'store'])->name('requirement.store');
Route::delete('/requirement/{requirement}', [RequirementController::class, 'destroy'])->name('requirement.destroy');
Route::put('/requirement/{requirement}', [RequirementController::class, 'update'])->name('requirement.update');

