<?php

use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TableController;

// Tambahkan controller baru yang digunakan:
use App\Http\Controllers\StuntingController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\PersentaseController;

use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('points', PointsController::class);
Route::resource('polylines', PolylinesController::class);
Route::resource('polygons', PolygonsController::class);

// Ini adalah tambahan route untuk data stunting, puskesmas, jalan, dan persentase stunting
Route::resource('stunting', StuntingController::class);
Route::resource('puskesmas', PuskesmasController::class);
Route::resource('jalan', JalanController::class);
Route::resource('persentase', PersentaseController::class);

Route::get('/map', [PointsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('map');

Route::get('/table', [TableController::class, 'index'])->name('table');

require __DIR__.'/auth.php';
