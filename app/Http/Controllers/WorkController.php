<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\Product;
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
    public function its_completed($id,Request $request){
        if($request->back){
            $data = explode(',',$id);
        foreach($data as $val){
            $sales_item = SalesItem::find($val);
            $sales_item->status = 0;
            $sales_item->update();
        }
        }elseif($request->backdone){
            $data = explode(',',$id);
            foreach($data as $val){
                $sales_item = SalesItem::find($val);
                $sales_item->status = 1;
                $sales_item->update();
            }
        }else{
        $data = explode(',',$id);
        foreach($data as $val){
            $sales_item = SalesItem::find($val);
            $sales_item->status = 2;
            $sales_item->update();
        }
    }
        return redirect()->back()->with("success","تم العملية بنجاح");
    }
    public function all_progress(){
        $item = SalesItem::select("products.name","clients.name as cl_name","clients.phone","sales_items.*")
        ->join("products","products.id","=","sales_items.prodid")
        ->join("salesbills","salesbills.id","=","sales_items.sales_id")
        ->join("clients","clients.id","=","salesbills.client")
        ->paginate(10);
        $product = Product::all();
        $client = client::all();
        return view('frontend.all_progress',['data'=>$item,"product"=>$product,"client"=>$client]);
    }
    public function allProgressSearch(Request $request){
        $item = SalesItem::query();
        $item->select("products.name","clients.name as cl_name","clients.phone","sales_items.*")
        ->join("products","products.id","=","sales_items.prodid")
        ->join("salesbills","salesbills.id","=","sales_items.sales_id")
        ->join("clients","clients.id","=","salesbills.client");
        if(isset($request->descrip)){
            $item->where("descripe","like","%$request->descrip%");
        }
        if(isset($request->product)){
            $item->where("prodid",$request->product);
        }
        if(isset($request->client)){
            $item->where("prodid",$request->client);
        }
        $product = Product::all();
        $client = client::all();
        return view('frontend.all_progress',['data'=>$item->paginate(10),"product"=>$product,"client"=>$client])->render();
    }
}
