<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PurchasesbillConttroller;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RawmaterialsController;
use App\Http\Controllers\SalesbillController;
use App\Http\Controllers\SystemMangControl;
use App\Http\Controllers\SystemMangController;
use App\Http\Controllers\userController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\ControlMaterialController;
use App\Http\Controllers\customersController;
use App\Http\Controllers\TreasuryController;
use App\Http\Controllers\WDTreasuryController;
use App\Models\ControlMaterial;
use App\Models\Purchasesbill;
use App\Models\Salesbill;
use App\Models\Treasury;
use App\Models\WDTreasury;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'active']);
Route::get('/registeruser', [App\Http\Controllers\HomeController::class, 'Register'])->name('registeruser')->middleware(['auth', 'active', 'admin']);
Route::get('/deleteuser/{id}', [App\Http\Controllers\HomeController::class, 'deleteuser'])->name('deleteuser')->middleware(['auth', 'active',"can:حذف المستخدمين"]);
Route::get('/statususer/{id}', [App\Http\Controllers\HomeController::class, 'statususer'])->name('sataususer')->middleware(['auth', 'active',"can:تعديل المستخدمين"]);
Route::POST('/storeuser', [App\Http\Controllers\HomeController::class, 'store'])->name('storeuser')->middleware(['auth', 'active',"can:اضافة المستخدمين"]);
Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account')->middleware(['auth', 'active']);
Route::get('/report-material', [App\Http\Controllers\HomeController::class, 'report_material'])->name('report.material')->middleware(['auth', 'active']);



Route::get("logout-user", function () {
    Auth::logout();
    return redirect()->route("login");
})->name("logout_user");

// Route::resource('purchases',PurchasesController::class);
Route::resource('mange_system', SystemMangControl::class)->middleware(['auth', 'active','can:تعديل اعدادت النظام']);
// Route::get("mange_system",[SystemMangControl::class,'index'])->name("system");
Route::resource('rawmaterials', RawmaterialsController::class)->middleware(['auth', 'active',"can:عرض المواد الخام"]);

Route::resource('invoices', InvoicesController::class);
Route::post('material/update', [RawmaterialsController::class, 'update'])->name("materialupdate")->middleware(['auth', 'active',"can:تعديل المنتجات"]);
Route::get('material/edit/{id}', [RawmaterialsController::class, 'edit'])->name("materialedit")->middleware(['auth', 'active',"can:تعديل المنتجات"]);
Route::get('material/delete/{id}', [RawmaterialsController::class, 'delete'])->name("materialdelete")->middleware(['auth', 'active',"can:حذف المنتجات"]);

Route::get('check_bill/{id}', function ($id) {
    if (Salesbill::find($id)->status == 0) {
        return response()->json(["success" => "تم الحذف بنجاح"], 200);
    } else {
        return response()->json(["mass" => "يجب اغلاق الفاتورة اولا"], 200);
    }
})->name('check_bill')->middleware(['auth', 'active']);

Route::get('check_purbill/{id}', function ($id) {
    if (Purchasesbill::find($id)->status == 0) {
        return response()->json(["success" => "تم الحذف بنجاح"], 200);
    } else {
        return response()->json(["mass" => "يجب اغلاق الفاتورة اولا"], 200);
    }
})->name('check_purbill')->middleware(['auth', 'active']);

Route::resource('users', usersController::class)->middleware(['auth',"can:عرض المستخدمين"]);
Route::delete("users/{id}", [usersController::class, "delete"])->name('users.delete');
Route::resource('customers', customersController::class)->middleware(['auth', 'active','can:اداة الموردين']);
Route::resource('clients', clientsController::class)->middleware(['auth', 'active','can:اداة العملاء']);
Route::get('/invicebill/{id}', [AdminController::class, 'invicebill'])->name('invicebill')->middleware(['auth', 'active']);
Route::get('/invicepur/{id}', [AdminController::class, 'invicepur'])->name('invicepur')->middleware(['auth', 'active']);
Route::get('/work/{id}', [AdminController::class, 'work'])->name('work')->middleware(['auth', 'active']);
Route::get('/invicereport', [AdminController::class, 'report'])->name('invicereport')->middleware(['auth', 'active']);
Route::get('/pay_report/{id}', [AdminController::class, 'pay'])->name('invicepay')->middleware(['auth', 'active']);

Route::get('/exc/{id}', [AdminController::class, 'exc'])->name('inviceexc')->middleware(['auth', 'active']);

Route::controller(TreasuryController::class)->group(function () {
    Route::prefix("treasury")->group(function () {
        Route::middleware(['auth', 'can:محاسب'])->group(function () {
            Route::get("index", 'index')->name('treasury.index');
            Route::post('store', 'store')->name('treasury.store');
            Route::post('deposit', 'deposit')->name("treasury.deposit");
        });
    });
});

Route::resource("asset", AssetController::class)->middleware(['auth', "can:محاسب"]);
Route::resource("Wdtreasury", WDTreasuryController::class)->middleware(['auth', "can:محاسب"]);

Route::controller(ControlMaterialController::class)->group(function(){
    Route::prefix("cm")->group(function(){
        Route::middleware(['auth',"can:اضافة مادة خام"])->group(function(){
            Route::get("add","index_add")->name("add.cm");
            Route::get("min","index_min")->name("min.cm");
            Route::post("store","store")->name("cm.store");
            Route::delete("/{id}","destroy")->name("cm.destroy");
        });
    });
});
