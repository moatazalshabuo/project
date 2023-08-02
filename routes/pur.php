<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RawmaterialsController;
use App\Http\Controllers\PurchasesbillConttroller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchasesitemsController;
// use App\Http\Controllers\ClientController;
use App\Http\Controllers\Reception_reports;
use App\Http\Controllers\SalesItemController;
use App\Models\Customer;
use App\Models\Purchasesbill;

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

Route::controller(PurchasesbillConttroller::class)->group(function(){
    Route::prefix("Purchasesbill")->group(function(){
        Route::middleware(['auth','active'])->group(function(){
            Route::get("index/{id?}","index")->name("Purchasesbill")->middleware('can:فواتير المشتريات');
            Route::get('create',"create")->name("Purchasesbill_create")->middleware('can:فواتير المشتريات');
            Route::get("edit/{salesbill}","edit")->name("purchasesbill_edit")->middleware('can:فواتير المشتريات');
            Route::post("save/","save")->name("purchasesbill_save")->middleware('can:فواتير المشتريات');
            // Route::get("change_prod/{id}","select_prod")->name("selectprod");
            Route::get("get_bill/{id?}","get_bill_data")->name("get_purbill")->middleware('can:فواتير المشتريات');
            Route::post('exchnge_receipt', "pay")->name("Exchange_receipt")->middleware('can:محاسب');
            Route::post('exchnge-exc', "pay1")->name("Exchange-exc")->middleware('can:محاسب');
        });
    });
});

Route::controller(PurchasesitemsController::class)->group(function(){
    Route::prefix("Purchasesitem")->group(function(){
        Route::middleware(['auth','active',"can:فواتير المشتريات"])->group(function(){
            Route::post("add","create")->name("add_puritem");
            Route::get("getTotalItem/{id}","getItemTotal")->name("getItempurbill");
            Route::get("delete/{id}","destroy")->name("deletePurItem");
            Route::get("edit/{id}","edit_item")->name("editPurItem");
        });
    });
});

Route::controller(RawmaterialsController::class)->group(function(){
    Route::middleware(['auth','active'])->group(function(){
    Route::get("getmatedata/{id}","getoldprice")->name("getoldprice");
    });
});
Route::controller(CustomerController::class)->group(function(){
    Route::prefix("custom")->group(function(){
        Route::middleware(['auth','active'])->group(function(){
            Route::get("showSelect/{id?}","show_select")->name("customSelect");
            Route::post("create","create")->name("createCustom");
        });
    });
});
// Route::get("test",function(){
//     Helper::check_materil(8,155);
// });
