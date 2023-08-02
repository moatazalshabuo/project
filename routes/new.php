<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products;
use App\Models\Product;
use App\Http\Controllers\SalesbillController;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Reception_reports;
use App\Http\Controllers\SalesItemController;
use App\Models\rawmaterials;

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

/*  start product page all staff  */
Route::controller(Products::class)->group(function(){
    Route::middleware(['auth','active','can:عرض المنتجات'])->group(function(){
        Route::get('/products',"index")->name("productsManage");
        Route::get("product/delete/{id}","delete")->name("deleteprod")->middleware('can:حذف المنتجات');
        Route::post("product/editprod/","editprod")->name("editprod")->middleware('can:تعديل المنتجات');
        Route::post('/product/addprod',"add_pro")->name("add_prod")->middleware('can:اضافة منتج');
        Route::post("/product/update-prod","update")->name("up_prod")->middleware('can:تعديل المنتجات');
        Route::get("/product/activeprod/{id}","active")->name("activeprod")->middleware('can:تعديل المنتجات');
        Route::get("/product/unactiveprod/{id}","unactive")->name("unactiveprod")->middleware('can:تعديل المنتجات');
        Route::get("get_type_product/{id}","get_type_product")->name('get_type_product');
        /* material in page product */
        Route::get("product/get-mati/{id}","getMatiSel")->name("get-mati");
        Route::post("product/add-mate","addMeta")->name("add-mate");
        Route::get("product/del-mate/{id}","delMeta")->name("del-mate");
        Route::get("get_type/{id}","get_type")->name("get_type");

        /* work hand in product  */
        Route::get("product/get-work/{id}","getWork")->name("get-work");
        Route::post("product/add-work","addwork")->name("add-work");
        Route::get("product/del-work/{id}","delWork")->name("del-work");
        Route::get("product/edit-work/{id}","editWork")->name("edit-work");

    });
});
Route::get("get-item",function(){
    $product = Product::all();
    foreach ($product as $item){
        echo "<tr>
            <td>$item->id</td>
            <td>$item->name</td>
            <td>";
            if($item->type_Q == 1){
              echo  "متر";}
              elseif($item->type_Q == 3){
                echo "متر مربع";
              }
            else{
               echo "قطعة";
            }
            echo "</td>
                <td>".floatval(Helper::cost($item->id))."</td>
                <td>".floatval($item->price)."</td><td>";
                if(auth()->user()->can('تعديل المنتجات'))
                if($item->status == 1){
                    echo " <button class='btn btn-danger ml-1 unactive-prod' id='$item->id' ><span class='spinner-border spinner-border-sm sp' style='display: none'></span><span  class='text'>ايقاف</span></button>";
                }else{
                    echo " <button class='btn btn-success ml-1 active-prod' id='$item->id' ><span class='spinner-border spinner-border-sm sp' style='display: none'></span><span  class='text'>تفعيل</span></button>";
                }
                echo "</td><td class='d-flex justify-content-center'>";
                if(auth()->user()->can('تعديل المنتجات'))
                    echo "<button class='btn btn-danger ml-1 btn-icon dele' id='$item->id' ><span class='spinner-border spinner-border-sm sp' style='display: none'></span><span  class='text'> <i class='mdi mdi-delete'></i></span></button>";
                if(auth()->user()->can('تعديل المنتجات'))
                    echo " <button  data-target='#modaldemo6' data-toggle='modal' class='btn btn-info btn-icon edit_product' id='$item->id'><i class='mdi mdi-transcribe'></i></button>";
                echo "</td>
            </tr>";
        }
})->name("getitem")->middleware(['auth','active']);

/*  end product page staff  */

/*  Start get data item material form page rawmaterial */
Route::get("get-item-mate",function(){
    $product = rawmaterials::select()->orderBy('id','DESC')->get();
    $i = 0;
    foreach ($product as $dates){
            echo "<tr>
            <td>$i</td>
            <td>$dates->material_name</td>
            <td>";
            if($dates->hisba_type == 1)
              { echo  "بمقاس المتر";}
            elseif ($dates->hisba_type == 2)
             {  echo "بمقاس الطرف";
            }elseif ($dates->hisba_type == 3)
            {  echo "بمقاس المتر المربع";
           }
            echo "</td><td>" .floatval($dates->quantity)." </td>
            <td>". floatval($dates->price) ."</td>
            <td>$dates->created_by </td>";
            echo "<td class='d-flex'>";
                if(Auth::user()->can("حذف مادة خام"))
                    echo "<a class='btn btn-danger ml-1 btn-icon' href='".route('materialdelete',$dates->id)."' ><i class='mdi mdi-delete'></i></a>";
                if(Auth::user()->can("تعديل مادة خام"))
                    echo "<button  data-target='#edit_material' data-toggle='modal' class='btn btn-info btn-icon edit_mate' id='$dates->id'><i class='mdi mdi-transcribe'></i></button>
            </td></tr>";$i+=1;
            }

})->name("getitem-mate")->middleware(['auth','active',"can:عرض المواد الخام"]);

/* end */


Route::get('/cards',function(){
    return view('background');
});

/*  start salesbill page all staff  */
Route::controller(SalesbillController::class)->group(function(){
    Route::prefix("Salesbill")->group(function(){
        Route::middleware(['auth','active'])->group(function(){
            Route::get("index/{id?}","index")->name("salesbill")->middleware('can:فواتير المبيعات');
            Route::get('create',"create")->name("salesbiil_create")->middleware('can:فواتير المبيعات');
            Route::get("edit/{salesbill}","edit")->name("salesbill_edit")->middleware('can:فواتير المبيعات');
            Route::post("save","save")->name("salesbill_save")->middleware('can:فواتير المبيعات');
            Route::get("getProduct/{id?}","product_select")->name("product_select")->middleware('can:فواتير المبيعات');
            Route::get("change_prod/{id}","select_prod")->name("selectprod")->middleware('can:فواتير المبيعات');
            Route::get("get_bill/{id?}","get_bill_data")->name("get_bill")->middleware('can:فواتير المبيعات');
            Route::post('pay_receipt', "pay")->name("pay_receipt")->middleware('can:محاسب');
            // ايصال القبض
            Route::get("client_pay/{id?}","client_pay")->name("client_pay")->middleware('can:محاسب');
        });
    });
});

Route::controller(SalesItemController::class)->group(function(){
    Route::prefix("SalesItem")->group(function(){
        Route::middleware(['auth','active','can:فواتير المبيعات'])->group(function(){
        Route::post("add","create")->name("add_item");
        Route::get("getTotalItem/{id}","getItemTotal")->name("getItembill");
        Route::get("delete/{id}","destroy")->name("deleteSaleItem");
        Route::get("edit/{id}","edit")->name("editSaleItem");
        });
    });
});

/* end */


/*  start client page all staff  */
Route::controller(ClientController::class)->group(function(){
    Route::prefix("client")->group(function(){
        Route::middleware(['auth','active'])->group(function(){
            Route::get("showSelect/{id?}","show_select")->name("clientSelect");
            Route::post("create","create")->name("createClient");
        });
    });
});
/*end*/

Route::controller(Reception_reports::class)->group(function(){
    Route::prefix("Reception")->group(function(){
        Route::middleware(['auth','active'])->group(function(){
            Route::post("salesbill","Salesbill")->name("ReceptionSalesbill");
        });
    });
});

