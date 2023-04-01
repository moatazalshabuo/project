<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RawmaterialsController;
use App\Http\Controllers\userController;
use App\Http\Controllers\usersController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Route::resource('purchases',PurchasesController::class);

Route::resource('rawmaterials',RawmaterialsController::class)->middleware('auth');

Route::resource('invoices',InvoicesController::class);
Route::post('material/update',[RawmaterialsController::class,'update'])->name("materialupdate");
Route::get('material/edit/{id}',[RawmaterialsController::class,'edit'])->name("materialedit");
Route::get('material/delete/{id}',[RawmaterialsController::class,'delete'])->name("materialdelete");

Route::resource('users',usersController::class);

Route::get('/pages/{page}', [AdminController::class, 'index']);

