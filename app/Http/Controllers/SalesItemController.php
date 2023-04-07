<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Salesbill;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SalesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $salesbill = Salesbill::find($request->id);
        // print($salesbill->id);die();
        if($salesbill->status == 1):
            
            $rules = ["product"=>"required|numeric","quant"=>"required|numeric|min:1|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/"];
            $message = ["product.required"=>"يجب ادخال صنف","product.numeric"=>"يجب ادخال صنف","quant.required"=>"الكمية يجب ان لاتكوم فارغة","quant.required"=>"الكمية يجب ان لاتكوم فارغة",];
            $request->validate($rules,$message);
            // print($request->quant);die();
            $product = Product::find($request->product);
            if($product->price > 0){
            $error = Helper::check_materil($request->product,$request->quant);
            if(empty($error)){
                $id = SalesItem::create(['prodid'=>$request->product,
                "sales_id"=>$salesbill->id,
                "qoun"=>$request->quant,
                "descont"=>$request->descont,
                "total"=>($request->quant*$product->price)-$request->descont,
                "user_id"=>Auth::id()])->id;
                Helper::Collect_bill($salesbill->id);
                Helper::minus_from_mate($id);
                echo 1;
            }else{
                echo $error;
            }
        }else{
            echo "يرجى اضافة سعر للمنتج";
        }
        else:
            echo "الفاتورة مغلقة";
        endif;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getItemTotal($id)
    {
        //
        $bill = Salesbill::find($id);
        $data = SalesItem::join("products","products.id","=","sales_items.prodid")->
        select("products.name","sales_items.*")->where("sales_items.sales_id",$id)->orderBy("id","DESC")->get();
        $total = array("total"=>$bill->total,"sincere"=>$bill->sincere,"Residual"=>$bill->Residual,"tbody"=>"");
        $i = 0;
        foreach($data as $val){
            $i++;
            $total['tbody'] .= "<tr >
            <td>".$i."</td>
            <td>".$val->name."</td>
            <td>".$val->qoun."</td>
            <td>".$val->descont."</td>
            <td>".$val->total."</td>
            <td>".$val->created_at."</td>
            <td class='d-flex justify-content-end'>
                    <button type=button class='btn btn-info ml-1 btn-icon dele' id='".$val->id."'><i class='mdi mdi-delete'></i></button>
                    <button type=button class='btn btn-danger btn-icon edit' id='".$val->id."'><i class='mdi mdi-transcribe'></i></button>
                </td>
            </tr>";
        }
        echo json_encode($total);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //

        $salesItem = SalesItem::find($id);
        $salesbill = Salesbill::find($salesItem->sales_id);
        if($salesbill->status == 1){
        $data = array(
            "type"=>1,
            "product" => $salesItem->prodid,
            "price" => ($salesItem->total + $salesItem->descont)/$salesItem->qoun,
            "qoun"=>$salesItem->qoun,
            "total"=>$salesItem->total+$salesItem->descont,
            "descont"=>$salesItem->descont
        );
        $de = Helper::add_from_mate($salesItem->id);
        
        $salesItem->delete();
        $re = Helper::Collect_bill($salesItem->sales_id);
        }else{
            $data=array("type"=>2,"massege"=>"الفتورة مغلقة");
            
        }
        echo json_encode($data);
        
    }

 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salesItem = SalesItem::find($id);
        $salesbill = Salesbill::find($salesItem->sales_id);
        if($salesbill->status == 1){
        Helper::add_from_mate($salesItem->id);
        // Helper::Collect_bill($salesItem->sales_id);
        $salesItem->delete();
        $re = Helper::Collect_bill($salesItem->sales_id);
        echo 1;
    }else{
        echo "الفاتورة مغلقة";
    }
    }
}
