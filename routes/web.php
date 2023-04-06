<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PurchasesbillConttroller;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RawmaterialsController;
use App\Http\Controllers\SalesbillController;
use App\Http\Controllers\userController;
use App\Http\Controllers\usersController;
use App\Models\Salesbill;
use GuzzleHttp\Psr7\Response;
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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/registeruser', [App\Http\Controllers\HomeController::class, 'Register'])->name('registeruser')->middleware('auth');
Route::get('/deleteuser/{id}', [App\Http\Controllers\HomeController::class, 'deleteuser'])->name('deleteuser')->middleware('auth');
Route::POST('/storeuser', [App\Http\Controllers\HomeController::class, 'store'])->name('storeuser')->middleware('auth');

// Route::resource('purchases',PurchasesController::class);

Route::resource('rawmaterials',RawmaterialsController::class)->middleware('auth');

Route::resource('invoices',InvoicesController::class);
Route::post('material/update',[RawmaterialsController::class,'update'])->name("materialupdate")->middleware('auth');
Route::get('material/edit/{id}',[RawmaterialsController::class,'edit'])->name("materialedit")->middleware('auth');
Route::get('material/delete/{id}',[RawmaterialsController::class,'delete'])->name("materialdelete")->middleware('auth');

Route::get('check_bill/{id}',function($id){
    if(Salesbill::find($id)->status == 0){
        return response()->json(["success"=>"تم الحذف بنجاح"], 200);  
    }else{
        return response()->json(["mass"=>"يجب اغلاق الفاتورة اولا"], 200);  
    }
})->name('check_bill')->middleware('auth');

Route::resource('users',usersController::class)->middleware('auth');
Route::resource('mange_system',SystemMangController::class);
Route::get('/invicebill/{id}', [AdminController::class, 'invicebill'])->name('invicebill')->middleware('auth');


