<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Purchasesbill;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use Exception;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function compareDates($date1, $date2){
        return strtotime($date1) - strtotime($date2);
    }
    public static function cost(int $id)
    {
        $mymaterial = DB::table('proudct_material')->join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")
        ->select(DB::raw("SUM((rawmaterials.price * proudct_material.quan)) as sum"))
        ->where(['proudct_material.proid'=> $id])->get();
        // $product = DB::table('products')->find($id);
        $work = DB::table('working_hand')->select(DB::raw("SUM(price) as sum"))->where(['proid'=>$id])->get();
        $sum1 = empty($work[0]->sum)?0:$work[0]->sum;
        $sum2 = empty($mymaterial[0]->sum)?0:$mymaterial[0]->sum;
        return ($sum1 + $sum2); 
    }
    public static function Collect_bill($id){
        $salesbill = Salesbill::find($id);
        $mymaterial = DB::table('sales_items')->select(DB::raw("SUM(total) as totalsum"))
        ->where(['sales_id'=> $salesbill->id])->get();
        $salesbill->total = isset($mymaterial[0]->totalsum)?$mymaterial[0]->totalsum:0;
        $salesbill->update();
    }
    public static function Collect_purbill($id){
        $salesbill = Purchasesbill::find($id);
        $mymaterial = DB::table('purchases_items')->select(DB::raw("SUM(total) as totalsum"))
        ->where(['purchases_id'=> $salesbill->id])->get();
       
            $salesbill->tolal = isset($mymaterial[0]->totalsum)?$mymaterial[0]->totalsum:0;
        $salesbill->update();
    }
    public static function check_materil($id,$total){
        $mymaterial = DB::table("proudct_material")->join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")
        ->select(["rawmaterials.*","proudct_material.quan"])->where(["proudct_material.proid"=>$id])->get();
        $error = ""; 
        foreach($mymaterial as $item):
            $error .= ($item->quantity < ($item->quan * $total))?" كمية العنصر <strong>(". $item->material_name .")</strong> لاتكفي للمنتج المطلوب  <br>":"";
        endforeach;
        return $error;
    }
    public static function minus_from_mate($id){
        $salesItem = SalesItem::find($id);
        $mate = DB::table('proudct_material')->select(DB::raw("($salesItem->qoun * proudct_material.quan) as coun"),"proudct_material.*")
        ->where(['proudct_material.proid'=> $salesItem->prodid])->get();
        
        foreach($mate as $val){
            $raw = rawmaterials::find($val->rawid);
            $raw->quantity = ($raw->quantity - $val->coun);
            $raw->update();
        }

    }

    public static function add_from_mate($id){
        $salesItem = SalesItem::find($id);
        $mate = DB::table('proudct_material')->select(DB::raw("($salesItem->qoun * proudct_material.quan) as coun"),"proudct_material.*")
        ->where(['proudct_material.proid'=> $salesItem->prodid])->get();
        // print_r($mate);
        foreach($mate as $val){
            $raw = rawmaterials::find($val->rawid);
            $raw->quantity = ($raw->quantity + $val->coun);
            $raw->update();
        }

    }
    public static function logo(){
        try{
            return DB::table('system_mangs')->select('logo_photo')->get()[0]->logo_photo;
        }catch(Exception $e){
            return "";
        }
        }
}

?>