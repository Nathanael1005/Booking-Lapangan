<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

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
    return view('index');
});

Auth::routes();

// user route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/sewalapangan', [App\Http\Controllers\HomeController::class, 'sewalapangan'])->name('sewalapangan');
Route::get('/formsewa', [App\Http\Controllers\HomeController::class, 'formsewa'])->name('formsewa');
Route::get('/formsewa/store', [App\Http\Controllers\HomeController::class, 'sewastore'])->name('formsewa.store');



// admin route
// Admin routes

Route::middleware(['auth'])->group(function () {
    Route::get('admin/request_sewa_lapangan', [AdminController::class, 'reqsewa'])->name('admin.reqsewa');
    Route::get('admin/acc_request_sewa/{id}', [AdminController::class, 'accreqsewa'])->name('admin.accreqsewa');
    Route::delete('admin/tolak_request_sewa/{id}', [AdminController::class, 'tlkreqsewa'])->name('admin.tlkreqsewa');
    Route::get('admin/acc_sewa_lapangan', [AdminController::class, 'accsewa'])->name('admin.accsewa');
    Route::get('admin/batal_acc_sewa/{id}', [AdminController::class, 'btlaccsewa'])->name('admin.btlaccsewa');
    Route::get('admin/exportPdf/{id}', [AdminController::class, 'exportPdf'])->name('admin.exportPdf');
    
    // New routes for adding admin
    Route::get('admin/create_admin', [AdminController::class, 'createAdmin'])->name('admin.createAdmin');
    Route::post('admin/store_admin', [AdminController::class, 'storeAdmin'])->name('admin.storeAdmin');

    // Admin resource routes
    Route::resource('admin', AdminController::class)->names([
        'index' => 'admin.index',
        'create' => 'admin.create',
        'store' => 'admin.store',
        'show' => 'admin.show',
        'edit' => 'admin.edit',
        'update' => 'admin.update',
        'destroy' => 'admin.destroy'
    ]);
});