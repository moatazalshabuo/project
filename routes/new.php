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
    Route::middleware(['auth','active','manager'])->group(function(){
        Route::get('/products',"index")->name("productsManage");
        Route::get("product/delete/{id}","delete")->name("deleteprod")->middleware('admin');
        Route::post("product/editprod/","editprod")->name("editprod")->middleware('admin');
        Route::post('/product/addprod',"add_pro")->name("add_prod")->middleware('admin');
        Route::post("/product/update-prod","update")->name("up_prod")->middleware('admin');
        Route::get("/product/activeprod/{id}","active")->name("activeprod")->middleware('admin');
        Route::get("/product/unactiveprod/{id}","unactive")->name("unactiveprod")->middleware('admin');
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
            else{
               echo "قطعة";
            }
            echo "</td>
                <td>".floatval(Helper::cost($item->id))."</td>
                <td>".floatval($item->price)."</td><td>";
                if(Auth::user()->user_type==1 || Auth::user()->user_type==0)
                if($item->status == 1){
                    echo " <button class='btn btn-danger ml-1 unactive-prod' id='$item->id' >ايقاف</button>";
                }else{
                    echo " <button class='btn btn-success ml-1 active-prod' id='$item->id' >تفعيل</button>";
                }
                echo "</td><td class='d-flex justify-content-center'>";
                if(Auth::user()->user_type==1)   
                echo "<button class='btn btn-danger ml-1 btn-icon dele' id='$item->id' ><i class='mdi mdi-delete'></i></button>
                    <button  data-target='#modaldemo6' data-toggle='modal' class='btn btn-info btn-icon edit_product' id='$item->id'><i class='mdi mdi-transcribe'></i></button>";
                echo "</td>
            </tr>";
        }
})->name("getitem")->middleware(['auth','active']);

/*  end product page staff  */ 

/*  Start get data item material form page rawmaterial */
Route::get("get-item-mate",function(){
    $product = rawmaterials::select()->orderBy('id','DESC')->get();
    foreach ($product as $dates){
            echo "<tr>         
            <td>$dates->id</td>
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
                if(Auth::user()->user_type==1 || Auth::user()->user_type==0)
                echo "<a class='btn btn-danger ml-1 btn-icon' href='".route('materialdelete',$dates->id)."' ><i class='mdi mdi-delete'></i></a>";
               echo "<button  data-target='#edit_material' data-toggle='modal' class='btn btn-info btn-icon edit_mate' id='$dates->id'><i class='mdi mdi-transcribe'></i></button>
            </td></tr>";
            }
        
})->name("getitem-mate")->middleware(['auth','active',"manager"]);

/* end */ 


Route::get('/cards',function(){
    return view('background');
});

/*  start salesbill page all staff  */
Route::controller(SalesbillController::class)->group(function(){
    Route::prefix("Salesbill")->group(function(){
        Route::middleware(['auth','active','Technical'])->group(function(){
            Route::get("index/{id?}","index")->name("salesbill");
            Route::get('create',"create")->name("salesbiil_create");
            Route::get("edit/{salesbill}","edit")->name("salesbill_edit");
            Route::post("save","save")->name("salesbill_save");
            Route::get("getProduct/{id?}","product_select")->name("product_select");
            Route::get("change_prod/{id}","select_prod")->name("selectprod");
            Route::get("get_bill/{id?}","get_bill_data")->name("get_bill");
            Route::post('pay_receipt', "pay")->name("pay_receipt");
            // ايصال القبض
            Route::get("client_pay/{id?}","client_pay")->name("client_pay");
        });
    });
});

Route::controller(SalesItemController::class)->group(function(){
    Route::prefix("SalesItem")->group(function(){
        Route::middleware(['auth','active','Technical'])->group(function(){
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
        Route::middleware(['auth','active','Technical'])->group(function(){
            Route::post("salesbill","Salesbill")->name("ReceptionSalesbill");
        });
    });
});

