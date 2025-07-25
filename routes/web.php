<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationImportController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/notifications', [NotificationController::class,'index'])->name('notifications.index');

Route::post('/notifications/import', [NotificationImportController::class, 'import'])->name('notifications.import');

Route::get('/notifications/create', [NotificationController::class,'create'])->name('notifications.create');
Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');

Route::post('/notifications/{id}/update', [NotificationController::class, 'updateCancelledStatus'])->name('notifications.updateCancelledStatus');