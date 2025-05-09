<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KtpController;
use App\Http\Controllers\UserActivityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/ktps', [KtpController::class, 'index'])->name('ktps.index');
    Route::get('/ktps/{ktp}', [KtpController::class, 'show'])->name('ktps.show');
    Route::get('/ktps/export/csv', [KtpController::class, 'exportCsv'])->name('ktps.export.csv');
    Route::get('/ktps/export/pdf', [KtpController::class, 'exportPdf'])->name('ktps.export.pdf');
    
    Route::middleware(['admin'])->group(function () {
        Route::get('/ktps/create', [KtpController::class, 'create'])->name('ktps.create');
        Route::post('/ktps', [KtpController::class, 'store'])->name('ktps.store');
        Route::get('/ktps/{ktp}/edit', [KtpController::class, 'edit'])->name('ktps.edit');
        Route::put('/ktps/{ktp}', [KtpController::class, 'update'])->name('ktps.update');
        Route::delete('/ktps/{ktp}', [KtpController::class, 'destroy'])->name('ktps.destroy');
        Route::post('/ktps/import/csv', [KtpController::class, 'importCsv'])->name('ktps.import.csv');
        
        Route::get('/user-activities', [UserActivityController::class, 'index'])->name('user-activities.index');
    });
});
