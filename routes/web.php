<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YajraController;

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

Route::get('/', [YajraController::class, 'index']);
Route::get('/get-data', [YajraController::class, 'getData'])->name('getData');
Route::get('/edit/{id}', [YajraController::class, 'editData'])->name('editData');
Route::put('/update/{id}', [YajraController::class, 'updateData'])->name('updateData');
Route::delete('/delete-user/{id}', [YajraController::class, 'deleteData']);
