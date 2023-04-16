<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\pay_receipt;
use Illuminate\Http\Request;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct()
    {
        
    }
    public function show_select($id = "")
    {
        $client = client::all();
        echo "<option value=''>اختر الزبون</option>";
        foreach($client as $val){
            $sele = ($id == $val->id)?"selected":"";
            echo "<option $sele value='".$val->id."'>".$val->name ." - ".$val->phone."</option>";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'=>["required",'max:255'],
            "phone"=>["required","unique:clients,phone",'max:30'],
            "email"=>['max:80'],
            "address"=>['max:191']
        ],["name.required"=>"يرجى ادخال الاسم","phone.required"=>"يرجى ادخال رقم الهاتف",
        "phone.unique"=>"رقم الهاتف موجود مسبقا"]);
        echo client::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "email"=>$request->email,
            "address"=>$request->address
        ])->id;
    }

    public function clint_index()
    {
        # code...
        $product = client::all();
        
        return view("frontend/clint",['product'=>$product]);
    }
    public function search_clint(Request $request)
    {
        // $where = array();
        $date = array();
        $Residual_s=0;
        $sincere_s=0;
        $data1 = array();
        $data = array();
        # code...

        $request->validate([
            'client'=>"required"
        ],['client.required'=>"يرجى اختيار الزبون"]);
            $client = $request->client;

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

        $prus = pay_receipt::select("pay_receipt.*",'users.name')->
        join("salesbills","salesbills.id","=","pay_receipt.bill_id")->
        join("users","users.id","=","pay_receipt.created_by")->
        where("salesbills.client",$client)->
        whereBetween('pay_receipt.created_at',[$date])->get();

        $prus1 = Salesbill::select("salesbills.*","users.name")->
        join("users","users.id","=","salesbills.created_by")->
        where('client',$client)->     
        whereBetween('salesbills.created_at',[$date])->get();  

        }else{

            $prus = pay_receipt::select("pay_receipt.*",'users.name')->
            join("salesbills","salesbills.id","=","pay_receipt.bill_id")->
            join("users","users.id","=","pay_receipt.created_by")->
            where("salesbills.client",$client)->get();

            $prus1 = Salesbill::select("salesbills.*","users.name")->
            join("users","users.id","=","salesbills.created_by")->
            where('client',$client)->get();        
        }
        foreach($prus as $val){
            array_push($data1,
            ['id_bill'=>$val->id,
            'price'=>$val->price,
            'created_at'=>$val->created_at,
            "username"=>$val->name,
            "type"=>"ايصال صرف",
            "type_n"=>'1'
            ]
           );
           }   
           foreach($prus1 as $val){
            array_push($data1,
            ['id_bill'=>$val->id,
            'price'=>$val->total,
            'sincere'=>$val->sincere,
            'Residual'=>$val->Residual,
            'created_at'=>$val->created_at,
            "username"=>$val->name,
            "type"=>"فاتورة مبيعات",
            "type_n"=>'2'
            ]
            
           );
           $sincere_s += $val->sincere;
            $Residual_s += $val->Residual;
           }
        // print_r($prus.$prus1);die();
           $data = collect($data1)->sortBy('created_at')->reverse()->toArray();
        //    echo $data[0]['type_n'] == '1';
        //    var_dump($data);die();
        
        return redirect()->route('clint_index')->with(['data'=>$data,
            'sincere_s'=>empty($sincere_s)?'0':$sincere_s,
            'Residual_s'=>empty($Residual_s)?'0':$Residual_s
        ]);
    }
}
