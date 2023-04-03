<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Customer;
use App\Models\Purchasesitem;
use App\Models\Purchasesbill;
use App\Models\rawmaterials;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasesbillConttroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = "")
    {
        // echo Auth::id();die();
        // $data = Purchasesbill::find($id);
        if(Auth::user()->user_type !=1)
        $wher = (!empty($id) && !empty(Purchasesbill::find($id)) )?["created_by"=>Auth::id(),"purchasesbills.id"=>$id]:["created_by"=>Auth::id()];
        else
        $wher =(!empty($id) && !empty(Purchasesbill::find($id)) )?["purchasesbills.id"=>$id]:[];
        $last_bill = Purchasesbill::select("users.name","purchasesbills.*")
        ->join("users","users.id","=","purchasesbills.created_by")->where($wher)->orderby("id","DESC")->first();
        $rawmate = rawmaterials::all();
        if(!empty($last_bill)){
        $next = isset(Purchasesbill::find($last_bill->id + 1)->id)?Purchasesbill::find($last_bill->id + 1)->id:"";
        $prev = isset(Purchasesbill::find($last_bill->id - 1)->id)?Purchasesbill::find($last_bill->id - 1)->id:"";
        }else{
            $next= "";
            $prev ="";
        }

        return view("frontend/purchases",['data'=>$last_bill,"mate"=>$rawmate,'next'=>$next,"prev"=>$prev]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $id = Purchasesbill::create([
            'created_by'=>Auth::id(),
            "status"=>1,
            "custom"=>null
        ])->id;
        return redirect()->route("Purchasesbill",$id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchasesbill $salesbill)
    {
        //
        $salesbill->status = 1;
        $salesbill->update();
        return redirect()->route("Purchasesbill",$salesbill->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function save(Request $request)
    {
        
        $request->validate([
            "client"=>"required"
        ],[
            "client.required"=>"يرجى اختيار المورد",
        ]);
        
        Helper::Collect_bill($request->id);
        $salesbill = Purchasesbill::find($request->id);
        if($salesbill->status == 1){
        if($salesbill->tolal > 0){
            $salesbill->status = 0;
            $salesbill->Residual = $salesbill->tolal;
            // $salesbill->sincere = $request->sincere;
            // $salesbill->Residual = $salesbill->total - $request->sincere;
            $salesbill->custom = $request->client;
            $salesbill->update();
            // return redirect()->route("salesbill",$salesbill->id);
            $data = array("id"=>$salesbill->id);
        }else{
            $data=array("mass"=>"لايمكنك اغلاق فاتورة فارغة ");            
        }            
    }else{
        $data=array("mass"=>"الفاتورة مغلقة بالفعل");
    }
        echo json_encode($data);
    }
    public function rawmaterials_select(){
        // $proud_mate = material_product::select("proid")->get();
        // $data = array();
        // foreach($proud_mate as $val){
        //     array_push($data,$val->proid);
        // }
        // print_r($data);die();
        $product = rawmaterials::select("*")->get();
        echo "<option >اختر الصنف</option>";
        foreach ($product as $item):
            echo "<option value=$item->id>$item->material_name	</option>";
        endforeach;
    }
    public function select_prod($id){
        $product = rawmaterials::select("price")->where('id',$id)->get();
        $data = array("price"=>$product[0]->price);
        // $data['warning'] = "";
        // $item= rawmaterials::select("rawmaterials.material_name","rawmaterials.quantity")->join("rawmaterials","rawmaterials.id","=","rawmaterials.rawid")->get();
        // foreach($item as $val){
            // $data['warning'] .= "كميية ".$val->material_name . $val->quantity."<br>";  
        // }
        echo json_encode($data);
    }

    public function get_bill_data($id = 0){
        $salesbill = Purchasesbill::find($id);
        if(isset($salesbill->id)){
            if($salesbill->status == 0){
                $client = Customer::find($salesbill->custom);
                $data = array(
                    "tolal"=>$salesbill->tolal,
                    "sincere"=>$salesbill->sincere,
                    "Residual"=>$salesbill->Residual,
                    "custom_name"=>$client->name."".$client->phone,
                    // "client_id"=>$client->id,
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

    function pay(Request $request){
        $data = array();
        $request->validate([
            "bill_id"=>"required",
            "price"=>"required|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/|min:1"
        ],[
            "bill_id.required"=>"لايمكن ترك رقم الفاتورة فارغ",
            "price.required"=>"يرجى ادخال القيمة"
        ]);

        $salesbill = Purchasesbill::find($request->bill_id);
        // print_r($salesbill);die();
        if($request->price <= $salesbill->Residual){
            $Residual = $salesbill->Residual;
            $salesbill->Residual = $Residual - $request->price;
            $salesbill->sincere = $salesbill->sincere + $request->price;
            $salesbill->update();
            Exchange::create([
                "bill_id" => $request->bill_id,
                "price"=>$request->price,
                "created_by"=>Auth::id(),
                "type"=>0
            ]);
            $data['done'] = "تم تسجيل العملية بنجاح ";
        }else{
            $data['error'] = "القمية المدخلة اكبر من القيمة المتبقي";
        }
        echo json_encode($data);
    }
}
