<?php

use App\Http\Controllers\{AuthController, CommonController, UserController};
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

Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'handleLogin'])->name('auth.handleLogin');

Route::get('/auth/logout', [AuthController::class, 'handleLogout'])->name('auth.handleLogout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.search');
        Route::get('/export-csv', [UserController::class, 'exportCSV'])->name('user.exportCSV');

        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/create', [UserController::class, 'store'])->name('user.store');

        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/edit/{id}', [UserController::class, 'update'])->name('user.update');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::prefix('common')->as('common.')->group(function () {
        Route::get('resetSearch', [CommonController::class, 'resetSearch'])->name('resetSearch');
    });
});
