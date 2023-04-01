<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports;
use Laravel\Ui\Presets\React;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use App\Http\Controllers\CustomerController;
Route::prefix("pay")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[Reports::class,"pay_index"])->name("pay_index");
        Route::post('search',[Reports::class,"search_pay"])->name("search_pay");
        Route::get('delete/{id}',[Reports::class,"delete_pay"])->name("delete_pay");
    });
});

Route::prefix("Exchange")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[Reports::class,"exc_index"])->name("exc_index");
        Route::post('search',[Reports::class,"search_exc"])->name("search_exc");
        Route::get('delete/{id}',[Reports::class,"delete_exc"])->name("delete_exc");
    });
});

Route::prefix("sales")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[Reports::class,"sales_index"])->name("sales_index");
        Route::post('search',[Reports::class,"search_sales"])->name("search_sales");
        // Route::get('delete/{id}',[Reports::class,"delete_sales"])->name("delete_sales");
    });
});
Route::prefix("pur")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[Reports::class,"pur_index"])->name("pur_index");
        Route::post('search',[Reports::class,"search_pur"])->name("search_pur");
    });
});

Route::prefix("moveprod")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[Reports::class,"moveprod_index"])->name("moveprod_index");
        Route::post('search',[Reports::class,"search_moveprod"])->name("search_moveprod");
    });
});

Route::prefix("moveraw")->group(function(){
    Route::middleware('auth')->group(function(){
    Route::get('index',[Reports::class,"moveraw_index"])->name("moveraw_index");
    Route::post('search',[Reports::class,"search_moveraw"])->name("search_moveraw");
    });
});

Route::prefix("clint")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[ClientController::class,"clint_index"])->name("clint_index");
        Route::post('search',[ClientController::class,"search_clint"])->name("search_clint");
    });
});

Route::prefix("custom")->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('index',[CustomerController::class,"cust_index"])->name("cust_index");
        Route::post('search',[CustomerController::class,"search_cust"])->name("search_cust");
    });
});


// Route::get("clint",function(){
//     return view('rawmaterials/clint');
// });