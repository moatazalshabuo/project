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
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;

class SalesbillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = "")
    {
        if(Auth::user()->user_type !=1){

            $wher = (!empty($id) && !empty(Salesbill::find($id)) )?["created_by"=>Auth::id(),"salesbills.id"=>$id]:["created_by"=>Auth::id()];
            $pages = Salesbill::where("created_by",Auth::id())->get();
        }else{

            $wher =(!empty($id) && !empty(Salesbill::find($id)) )?["salesbills.id"=>$id]:[];
            $pages = Salesbill::all();      
        }

        $last_bill = Salesbill::select("users.name","salesbills.*")->join("users","users.id","=","salesbills.created_by")->where($wher)->orderby("id","DESC")->first();
        
        if(!empty($last_bill)){
    
            $index = array();

			foreach($pages as $val)
			{
				array_push($index, $val['id']);
			}
            // احضار انديكس الصفحة الحالة 
			$current = array_search($last_bill->id,$index);
            $first = $index[0];
            $last = $index[count($index) - 1];
			$next = isset($index[$current + 1])?$index[$current + 1]:"";
			$prev = isset($index[$current - 1])?$index[$current - 1]:"";
            
    }else{
            $next = "";
            $prev ="";
            $last = "";
            $first = "";
        }
        return view("frontend/sales",['data'=>$last_bill,'next'=>$next,"prev"=>$prev,"last"=>$last,"first"=>$first]);
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
            "client"=>"required",
            "price"=>"required|numeric|min:1|max:999999"
        ],[
            "client.required"=>"يجب اختيار زبون",
            "price.required"=>"يرجى ادخال القيمة"
        ]);
       
        $totls = Salesbill::select(DB::raw("SUM(Residual) as Residualsum"))
        ->where("client",$request->client)->get();
        if(isset($totls[0]) && $totls[0]->Residualsum >= $request->price){
            $price = $request->price;
            $bills = Salesbill::select("id")->where(["client"=>$request->client,"status"=>'0'])->where("Residual",">","0")->orderBy("id","DESC")->get();
            foreach($bills as $val){
                $sal = Salesbill::find($val->id);
                if($price > 0){
                if($price <= $sal->Residual){
                    $sal->Residual = $sal->Residual - $price;
                    $sal->sincere = $sal->sincere + $price;
                    $sal->update();
                    $price = 0;
                }else{
                    $price = $price - $sal->Residual;
                    $sal->sincere = $sal->sincere + $sal->Residual;
                    $sal->Residual = 0;
                    $sal->update();

                }
                }
            }
            $data['id'] = pay_receipt::create([
                "client_id" => $request->client,
                "price"=>$request->price,
                "created_by"=>Auth::id()
            ])->id;
            $data['done'] = "تم تسجيل العملية بنجاح ";
        }else{
            $data['error'] = "القمية المدخلة اكبر من القيمة المتبقي";   
        }
    
    echo json_encode($data);
    }
    

// ايصالات القبض
 
public function client_pay($id = ""){
    if($id != ""){
    $salesbill = Salesbill::select("id")->where(["client"=>$id,"status"=>'0'])->get();
    $html = "<option value=''>اختر الفاتورة </option>";
    foreach($salesbill as $val){
        $html .= "<option value=".$val['id'].">".$val['id']."</option>";
    }
    $totls = Salesbill::select(DB::raw("SUM(total) as totalsum"),DB::raw("SUM(sincere) as sinceresum"),DB::raw("SUM(Residual) as Residualsum"))->where("client",$id)->get();
    $data = array("salesbill"=>$html,"sincere"=>$totls[0]->sinceresum,"Residual"=>$totls[0]->Residualsum,"total"=>$totls[0]->totalsum);
    echo json_encode($data);
}else{
    echo "";
}
}
}
