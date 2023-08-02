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
            $rules = ["product"=>"required|numeric",];
            $message = ["product.required"=>"يجب ادخال صنف",
            "product.numeric"=>"يجب ادخال صنف"];
            if(isset($request->quant)){
                if(isset(Product::find($request->product)->id) &&  Product::find($request->product)->type_Q == 2){
                    $rules['quant'] = "required|integer|min:0.0001|max:9999999";
                }else{
                    $rules['quant'] = "required|numeric|min:0.0001|max:9999999";
                }
            }else{
                $rules['length'] = 'required|numeric|min:0.0001|max:9999999';
                $rules['width'] = 'required|numeric|min:0.0001|max:9999999';
                // $quan = isset($re)
            }
            $request->validate($rules,$message);
            $quan = isset($request->quant1)?$request->quant1:1;
            $quantity = isset($request->quant)?$request->quant:(($request->length * $request->width)*$quan);
            $product = Product::find($request->product);
            if($product->price > 0){
            $error = Helper::check_materil($request->product,$quantity);
            if(empty($error)){
                $price = $product->price;
                $descout = 0;
                // if(!empty($))
                $id = SalesItem::create(['prodid'=>$request->product,
                "sales_id"=>$salesbill->id,
                "qoun"=>$quantity,
                "new_price"=>$request->descont1,
                "descont"=>$request->descont,
                "descripe"=>$request->descripe,
                "total"=>ceil($quantity*$price-$request->descont),
                "length"=>$request->length,
                "width"=>$request->width,
                "count"=>$quan,
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
        select("products.name","products.type_Q","sales_items.*")->where("sales_items.sales_id",$id)->orderBy("id","DESC")->get();
        $total = array("total"=>$bill->total,"sincere"=>$bill->sincere,"Residual"=>$bill->Residual,"tbody"=>"");
        $i = 0;
        foreach($data as $val){
            $i++;
            $total['tbody'] .= "<tr>
            <td>".$i."</td>
            <td>".$val->name."</td>
            <td>".$val->descripe."</td>
            ";
            if($val->type_Q == 3)
            $total['tbody'] .= "<td>".$val->length." * ".$val->width."</td>";
            else
            $total['tbody'] .= "<td>".floatval($val->qoun)."</td>";
            $total['tbody'] .= "<td>".floatval($val->descont)."</td>
            <td>".floatval($val->total)."</td>";
            if($val->status == 0)
            $total['tbody'] .= "<td>قيد العمل</td>";
            elseif($val->status == 1)
            $total['tbody'] .= "<td>مكتمل</td>";
            else
            $total['tbody'] .= "<td> مستلم</td>";
            $total['tbody'] .= "<td>".$val->created_at."</td>
            <td class='d-flex justify-content-end'>
                    <button type=button class='btn btn-info ml-1 btn-icon dele' id='".$val->id."'><span class='spinner-border spinner-border-sm sp' style='display: none'></span><span  class='text'><i class='mdi mdi-delete'></i></span></button>
                    <button type=button class='btn btn-danger btn-icon edit' id='".$val->id."'><span class='spinner-border spinner-border-sm sp' style='display: none'></span><span  class='text'><i class='mdi mdi-transcribe'></i></span></button>
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

        $salesItem = SalesItem::select('sales_items.*','products.price as pprice',"products.type_Q")->join('products',"products.id","=","sales_items.prodid")->where("sales_items.id",$id)->get()->first();
        $salesbill = Salesbill::find($salesItem->sales_id);
        if($salesbill->status == 1){
        $data = array(
            "type"=>1,
            "product" => $salesItem->prodid,
            "price" => $salesItem->pprice,
            "qoun"=>$salesItem->qoun,
            "total"=>$salesItem->total,
            "descont1"=>$salesItem->new_price,
            "descont"=>$salesItem->descont,
            "length"=>$salesItem->length,
            "width"=>$salesItem->width,
            "count"=>$salesItem->count,
            'type_q'=>$salesItem->type_Q
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
