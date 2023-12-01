<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobOfferDetailsController;
use App\Http\Controllers\PersonDetailsController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('jobOffer', JobOfferController::class);

Route::post('/requirement/{jobOffer}', [RequirementController::class, 'store'])->name('requirement.store');
Route::delete('/requirement/{requirement}', [RequirementController::class, 'destroy'])->name('requirement.destroy');
Route::put('/requirement/{requirement}', [RequirementController::class, 'update'])->name('requirement.update');

Route::put('/jobOfferDetails/{jobOffer}', [JobOfferDetailsController::class, 'update'])->name('jobOfferDetails.update');

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::get('/auth/register', [AuthController::class, 'registerForm'])->name('auth.registerForm');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/myProfile', [AuthController::class, 'edit'])->name('auth.edit')->middleware('auth');

Route::put('/personDetails/edit', [PersonDetailsController::class, 'update'])->name('personDetails.update');

Route::middleware('auth')->group( function () {
    Route::get('/application/{jobOffer}', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application/{jobOffer}', [ApplicationController::class, 'store'])->name('application.store');
    Route::get('/application', [ApplicationController::class, 'index'])->name('application.index');
    Route::delete('/application/{application}', [ApplicationController::class, 'destroy'])->name('application.destroy');
}); 

