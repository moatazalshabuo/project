<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function in_progress(){
        $item = SalesItem::select("products.name","clients.name as cl_name","clients.phone","sales_items.*")
        ->join("products","products.id","=","sales_items.prodid")
        ->join("salesbills","salesbills.id","=","sales_items.sales_id")
        ->join("clients","clients.id","=","salesbills.client")
        ->where("sales_items.status",0)->get();
        return view('frontend.in_progress',['data'=>$item]);
    }
    public function its_done($id){
        $data = explode(',',$id);
        foreach($data as $val){
            $sales_item = SalesItem::find($val);
            $sales_item->status = 1;
            $sales_item->update();
        }
        return redirect()->route('in_progress')->with("success","تم العملية بنجاح");
    }
    public function completed_works(){
        $item = SalesItem::select("products.name","clients.name as cl_name","clients.phone","sales_items.*")
        ->join("products","products.id","=","sales_items.prodid")
        ->join("salesbills","salesbills.id","=","sales_items.sales_id")
        ->join("clients","clients.id","=","salesbills.client")
        ->where("sales_items.status",1)->get();
        return view('frontend.completed_works',['data'=>$item]);
    }
    public function its_completed($id){
        $data = explode(',',$id);
        foreach($data as $val){
            $sales_item = SalesItem::find($val);
            $sales_item->status = 2;
            $sales_item->update();
        }
        return redirect()->route('completed_works')->with("success","تم العملية بنجاح");
    }
}
