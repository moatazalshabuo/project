<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\pay_receipt;
use App\Models\Product;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use PDO;
use Illuminate\Support\Facades\DB;
class Reports extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        // $this->middleware(check_type::class);
        // echo Auth::user();
        // print_r(User::find(Auth::id()));die();
        
    }

    //
    public function pay_index()
    {
        # code...
        if(Auth::user()->user_type == 3 || Auth::user()->user_type == 2){
            return redirect()->back()->with("back","غير مخول لك");
        }
        $client = client::all();
        return view("frontend/pay_report",['client'=>$client]);
    }
    public function search_pay(Request $request)
    {
        $where = array();
        $data = array();
        # code...
        if(isset($request->client) ){
            $where['client'] = $request->client;
        }
        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $where['from'] = $request->from;
            $where['to'] = $request->to;
        }
        if(isset($where['client']) && isset($where['from']) && isset($where['to'])){
            $data = pay_receipt::select("users.name","pay_receipt.*")->join('salesbills',"salesbills.id","=","pay_receipt.bill_id")->join("users","users.id","=","pay_receipt.created_by")->whereBetween('pay_receipt.created_at',[$where['from'],$where['to']])->where("client",$where['client'])->get();
        }elseif(isset($where['client'])){
            $data = pay_receipt::select("users.name","pay_receipt.*")->join('salesbills',"salesbills.id","=","pay_receipt.bill_id")->join("users","users.id","=","pay_receipt.created_by")->where("client",$where['client'])->get();
        }elseif(isset($where['from']) && isset($where['from'])){
            $data = pay_receipt::select("users.name","pay_receipt.*")->join('salesbills',"salesbills.id","=","pay_receipt.bill_id")->join("users","users.id","=","pay_receipt.created_by")->whereBetween('pay_receipt.created_at',[$where['from'],$where['to']])->get();
        }elseif(isset($request->all_time)){
            $data = pay_receipt::select("users.name","pay_receipt.*")->join('salesbills',"salesbills.id","=","pay_receipt.bill_id")->join("users","users.id","=","pay_receipt.created_by")->get();
        }
       
        return redirect()->route('pay_index')->with('data',$data);
    }

    public function delete_pay($id){
        $raw = pay_receipt::find($id);
        $salesbill = Salesbill::find($raw->bill_id);
        $salesbill->sincere = $salesbill->sincere - $raw->price;
        $salesbill->Residual = $salesbill->Residual + $raw->price;
        $salesbill->update();
        $raw->delete();
        return redirect()->route('pay_index')->with('success',"تم الحذف بنجاح");
    }

    public function exc_index()
    {
        # code...
        $client = Customer::all();
        
        return view("frontend/Exchange_report",['custom'=>$client]);
    }
    public function search_exc(Request $request)
    {
        $where = array();
        $data = array();
        # code...
        if(isset($request->custom) ){
            $where['custom'] = $request->custom;
        }
        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $where['from'] = $request->from;
            $where['to'] = $request->to;
        }
        if(isset($where['custom']) && isset($where['from']) && isset($where['to'])){
            $data = Exchange::select("users.name","exchange_receipt.*")->join('purchasesbills',"purchasesbills.id","=","exchange_receipt.bill_id")->join("users","users.id","=","exchange_receipt.created_by")->whereBetween('exchange_receipt.created_at',[$where['from'],$where['to']])->where("custom",$where['custom'])->get();
        }elseif(isset($where['custom'])){
            $data = Exchange::select("users.name","exchange_receipt.*")->join('purchasesbills',"purchasesbills.id","=","exchange_receipt.bill_id")->join("users","users.id","=","exchange_receipt.created_by")->where("custom",$where['custom'])->get();
        }elseif(isset($where['from']) && isset($where['from'])){
            $data = Exchange::select("users.name","exchange_receipt.*")->join('purchasesbills',"purchasesbills.id","=","exchange_receipt.bill_id")->join("users","users.id","=","exchange_receipt.created_by")->whereBetween('exchange_receipt.created_at',[$where['from'],$where['to']])->get();
        }elseif(isset($request->all_time)){
            $data = Exchange::select("users.name","exchange_receipt.*")->join('purchasesbills',"purchasesbills.id","=","exchange_receipt.bill_id")->join("users","users.id","=","exchange_receipt.created_by")->get();
        }
        return redirect()->route('exc_index')->with('data',$data);
    }

    public function delete_exc($id){
        // echo $id;die();
        $raw = Exchange::find($id);
        $salesbill = Purchasesbill::find($raw->bill_id);
        $salesbill->sincere = $salesbill->sincere - $raw->price;
        $salesbill->Residual = $salesbill->Residual + $raw->price;
        $salesbill->update();
        $raw->delete();
        return redirect()->route('exc_index')->with('success',"تم الحذف بنجاح");
    }
    public function sales_index()
    {
        # code...
        $user = User::all();
        
        return view("frontend/sales_report",['user'=>$user]);
    }
    public function search_sales(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...

        if($request->status != 2){
            $where['salesbills.status'] = $request->status;
        }
        if(isset($request->user) ){
            $where['salesbills.created_by'] = $request->user;
        }
        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }
        
        if(isset($date['from']) && isset($date['to'])){
            $data = Salesbill::select("users.name","salesbills.*")
            ->join("users","users.id","=","salesbills.created_by")->where($where)->whereBetween('salesbills.created_at',[$date['from'],$date['to']])->get();
        }else{
            $data = Salesbill::select("users.name","salesbills.*")->join("users","users.id","=","salesbills.created_by")->where($where)->get();
        }

        return redirect()->route('sales_index')->with('data',$data);
    }
    
    public function pur_index()
    {
        # code...
        $user = User::all();
        
        return view("frontend/purs_report",['user'=>$user]);
    }
    public function search_pur(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...

        if($request->status != 2){
            $where['purchasesbills.status'] = $request->status;
        }
        if(isset($request->user) ){
            $where['purchasesbills.created_by'] = $request->user;
        }
        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }
       
        if(isset($date['from']) && isset($date['to'])){
            $data = Purchasesbill::select("users.name","purchasesbills.*")->join("users","users.id","=","purchasesbills.created_by")->whereBetween('purchasesbills.created_at',[$date])->get();
        }else{
            $data = Purchasesbill::select("users.name","purchasesbills.*")->join("users","users.id","=","purchasesbills.created_by")->where($where)->get();
        }
        return redirect()->route('pur_index')->with('data',$data);
    }

    public function moveprod_index()
    {
        # code...
        $product = Product::all();
        
        return view("frontend/move_product",['product'=>$product]);
    }
    public function search_moveprod(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...
        $request->validate([
            'product'=>"required"
        ],['product.required'=>"يرجى اختيار صنف"]);
        if(isset($request->product) ){
            $where['sales_items.prodid'] = $request->product;
        }
        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }
       
        if(isset($date['from']) && isset($date['to'])){
            $data = SalesItem::select("products.name","sales_items.*","users.name as username")->join("users","users.id","=","sales_items.user_id")->join("products","products.id","=","sales_items.prodid")->whereBetween('sales_items.created_at',[$date])->get();
        }else{
            $data = SalesItem::select("products.name","sales_items.*","users.name as username")->join("users","users.id","=","sales_items.user_id")->join("products","products.id","=","sales_items.prodid")->where($where)->get();
        }
        return redirect()->route('moveprod_index')->with('data',$data);
    }

    public function moveraw_index()
    {
        # code...
        $product = rawmaterials::all();
        
        return view("frontend/move_rawmat",['product'=>$product]);
    }
    public function search_moveraw(Request $request)
    {
        // $where = array();
        $date = array();
        $data1 = array();
        // $data2 = array();
        $data = array();
        # code...

        $request->validate([
            'product'=>"required"
        ],['product.required'=>"يرجى اختيار المادة"]);
            $raw = $request->product;

        if(isset($request->from)){
            $request->validate([
                'to'=>"required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }
       //    $i=0;

       
       
        // print_r($dateArr);die();
       if(isset($date['from']) && isset($date['to'])){

        $prus = Purchasesitem::select("rawmaterials.material_name","purchases_items.*","users.name as username","rawmaterials.id as rawm")
       ->join("users","users.id","=","purchases_items.user_id")
       ->join("rawmaterials","rawmaterials.id","=","purchases_items.rawmati")->where('purchases_items.rawmati',$raw)
       ->whereBetween('purchases_items.created_at',[$date])->get();

       $prus1 = SalesItem::select('sales_items.sales_id',DB::raw("(sales_items.qoun * proudct_material.quan) as qaunt"),"sales_items.created_at","users.name","rawmaterials.material_name","rawmaterials.id as rawm")
       ->join('proudct_material',"proudct_material.proid","=","sales_items.prodid")
       ->join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")
       ->join("users","users.id","=","sales_items.user_id")
       ->where('proudct_material.rawid',$raw)->whereBetween('sales_items.created_at',[$date])->get();   

        }else{

            $prus = Purchasesitem::select("rawmaterials.material_name","rawmaterials.id as rawm","purchases_items.*","users.name as username")
            ->join("users","users.id","=","purchases_items.user_id")
            ->join("rawmaterials","rawmaterials.id","=","purchases_items.rawmati")->where('purchases_items.rawmati',$raw)
            ->get();

            $prus1 = SalesItem::select('sales_items.sales_id',DB::raw("(sales_items.qoun * proudct_material.quan) as qaunt"),"sales_items.created_at","users.name","rawmaterials.material_name","rawmaterials.id as rawm")
            ->join('proudct_material',"proudct_material.proid","=","sales_items.prodid")
            ->join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")
            ->join("users","users.id","=","sales_items.user_id")
            ->where('proudct_material.rawid',$raw)->get();        
        }
        foreach($prus as $val){
            array_push($data1,
            ['id_bill'=>$val->purchases_id,
            'name'=>$val->material_name,
            'rawid'=>$val->rawm,
            "qoa"=>$val->qoun,
            'created_at'=>$val->created_at,
            "username"=>$val->username,
            "type"=>1
            ]
           );
           }   
           foreach($prus1 as $val){
            array_push($data1,
            ['id_bill'=>$val->sales_id,
            'name'=>$val->material_name,
            'rawid'=>$raw,
            "qoa"=>$val->qaunt,
            'created_at'=>$val->created_at,
            "username"=>$val->name,
            "type"=>2
            ]
           );
           }
           $data = collect($data1)->sortBy('created_at')->reverse()->toArray();
        //    print_r($data);die();
        return redirect()->route('moveraw_index')->with('data',$data);
    }
}
