<?php

namespace App\Http\Controllers;
use App\Models\pay_receipt;
use App\Models\client;
use App\Models\material_product;
use App\Models\Salesbill;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Nette\Utils\Json;

class SalesbillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = "")
    {
        // echo Auth::id();die();
        $wher = (!empty($id) && !empty(Salesbill::find($id)))?["created_by"=>Auth::id(),"salesbills.id"=>$id]:["created_by"=>Auth::id()];
        $last_bill = Salesbill::select("users.name","salesbills.*")->join("users","users.id","=","salesbills.created_by")->where($wher)->orderby("id","DESC")->first();
        if(!empty($last_bill)){
        $next = isset(Salesbill::find($last_bill->id + 1)->id)?Salesbill::find($last_bill->id + 1)->id:"";
        $prev = isset(Salesbill::find($last_bill->id - 1)->id)?Salesbill::find($last_bill->id - 1)->id:"";
        }else{
            $next = "";
            $prev ="";
        }
        return view("frontend/sales",['data'=>$last_bill,'next'=>$next,"prev"=>$prev]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $id = Salesbill::create([
            'created_by'=>Auth::id(),
            "status"=>1
        ])->id;
        return redirect()->route("salesbill",$id);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salesbill $salesbill)
    {
        //
        $salesbill->status = 1;
        $salesbill->update();
        return redirect()->route("salesbill",$salesbill->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function save(Request $request)
    {
        
        $request->validate([
            "client"=>"required",
            "sincere"=>"required|min:0|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/"
        ],[
            "client.required"=>"يرجى اختيار الزبون",
            "sincere.required"=>"يرجى ادخال القمية المستلمة اذا توفرت او يمكن ادخال 0",
            "sincere.min"=>"لايمكن ادخال قيمة بالسالب"
        ]);
        $salesbill = Salesbill::find($request->id);
        if($salesbill->total > 0){
        if($request->sincere <= $salesbill->total){
            $salesbill->status = 0;
            $salesbill->sincere = $request->sincere;
            $salesbill->Residual = $salesbill->total - $request->sincere;
            $salesbill->client = $request->client;
            $salesbill->update();
            // return redirect()->route("salesbill",$salesbill->id);
            $data = array("id"=>$salesbill->id);            
        }else{
            $data=array("mass"=>"القيمة الخالصة اكبر من اجمالي الفاتورة");
        }
    }else{
        $data=array("mass"=>"لايمكن اغلاق فاتورة فارغة");

    }
        echo json_encode($data);
    }

    //============================================

    public function product_select($id = ""){
        $proud_mate = material_product::select("proid")->get();
        $data = array();
        foreach($proud_mate as $val){
            array_push($data,$val->proid);
        }
        // print_r($data);die();
        $product = Product::select("products.*")->where("status",'1')->whereIn("id",$data)->get();
        echo "<option >اختر الصنف</option>";
        foreach ($product as $item):
            $sele = ($id == $item->id)?"selected":"";
            echo "<option $sele value=$item->id>$item->name</option>";
        endforeach;
    }


    //============================================


    public function select_prod($id){
        $product = Product::select("price")->where('id',$id)->get();
        $data = array("price"=>$product[0]->price);
        $data['warning'] = "";
        $item= material_product::select("rawmaterials.material_name","rawmaterials.quantity")
        ->join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")
        ->whereRaw("rawmaterials.quantity <= 10 ")->get();
        foreach($item as $val){
            $data['warning'] .= "كمية 10 ".$val->material_name . $val->quantity."<br>";  
        }
        echo json_encode($data);
    }

    // ============================احضار بيانات التخليص للفاتورة ==================================

    public function get_bill_data($id = 0){
        $salesbill = Salesbill::find($id);
        if(isset($salesbill->id)){
            if($salesbill->status == 0){
                $client = client::find($salesbill->client);
                $data = array(
                    "total"=>$salesbill->total,
                    "sincere"=>$salesbill->sincere,
                    "Residual"=>$salesbill->Residual,
                    "client_name"=>$client->name."".$client->phone,
                    "client_id"=>$client->id,
                    "bill_no"=>$salesbill->id
                );
            }else{
                $data = array("error"=>"<p class='alert alert-danger'>الفاتورة غير مغلقة</p>");
            }
        }else{
            $data = array("error"=>"<p class='alert alert-danger'>الفاتورة غير موجودة</p>");
        }
        echo json_encode($data);
    }

    // ========== دالة تسجيل عميلة قبض باقي قيمة الفاتورة =====================

    function pay(Request $request){
        $data = array();
        $request->validate([
            "bill_id"=>"required",
            "price"=>"required|min:1|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/"
        ],[
            "bill_id.required"=>"لايمكن ترك رقم الفاتورة فارغ",
            "price.required"=>"يرجى ادخال القيمة"
        ]);

        $salesbill = Salesbill::find($request->bill_id);
        // print_r($salesbill);die();
        if($request->price <= $salesbill->Residual){
            $Residual = $salesbill->Residual;
            $salesbill->Residual = $Residual - $request->price;
            $salesbill->sincere = $salesbill->sincere + $request->price;
            $salesbill->update();
            pay_receipt::create([
                "bill_id" => $request->bill_id,
                "price"=>$request->price,
                "created_by"=>Auth::id()
            ]);
            $data['done'] = "تم تسجيل العملية بنجاح ";
        }else{
            $data['error'] = "القمية المدخلة اكبر من القيمة المتبقي";
        }
        echo json_encode($data);
    }


}
