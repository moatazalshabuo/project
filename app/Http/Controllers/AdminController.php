<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\pay_receipt;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\Salesbill;
use App\Models\SalesItem;
use App\Models\system_mang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invicebill($id)
    {
        // if(view()->exists($id)){

            $last_bill = Salesbill::select("users.name","salesbills.*","clients.name as cn","clients.phone")->join("users","users.id","=","salesbills.created_by")->join("clients","clients.id","=","salesbills.client")->where("salesbills.id",$id)->orderby("salesbills.id","DESC")->first();
            $data = SalesItem::join("products","products.id","=","sales_items.prodid")->select("products.name","products.price","sales_items.*")->where("sales_items.sales_id",$id)->orderBy("id","DESC")->get();
            if($data->count() > 0 && $last_bill->count() > 0){
                return view("frontend.invoice.invoice_bill1",['bill'=>$last_bill,"item"=>$data,"our"=>system_mang::select()->first()]);
            }else{
                return redirect()->back();
            }
    }

    public function pay($id)
    {
        // if(view()->exists($id)){

            $last_bill = pay_receipt::select("users.name","pay_receipt.*","clients.name as cn","clients.phone")
            ->join("users","users.id","=","pay_receipt.created_by")
            ->join("clients","clients.id","=","pay_receipt.client_id")->where("pay_receipt.id",$id)
            ->orderby("pay_receipt.id","DESC")->first();
            $totls = Salesbill::select(DB::raw("SUM(Residual) as Residualsum"))->where("client",$last_bill->client_id)->get();
            return view("frontend.invoice.pay",['bill'=>$last_bill,"total"=>$totls[0],"our"=>system_mang::select()->first()]);
    }

    public function exc($id)
    {
        // if(view()->exists($id)){
            $e = Exchange::find($id);
            if($e->type == 0){
                $last_bill = Exchange::select("users.name as username","exchange_receipt.*","purchasesbills.custom","customers.name as cn","customers.phone")
            ->join("users","users.id","=","exchange_receipt.created_by")
            ->leftJoin("purchasesbills","purchasesbills.id","=","exchange_receipt.bill_id")
            ->join("customers","customers.id","=","purchasesbills.custom")
            ->where("exchange_receipt.id",$id)
            ->orderby("exchange_receipt.id","DESC")->first();
            // print_r($last_bill);die();
            $totls = Purchasesbill::select(DB::raw("SUM(Residual) as Residualsum"))->where("custom",$last_bill->coust_id)->get();
            }else{
            $last_bill = $e;
            $totls = array(0);
            }
            return view("frontend.invoice.exc",['bill'=>$last_bill,"total"=>$totls[0],"our"=>system_mang::select()->first()]);
    }

    public function invicepur($id)
    {
        // if(view()->exists($id)){

            $last_bill = Purchasesbill::select("users.name","purchasesbills.*","customers.name as cn","customers.phone")->join("users","users.id","=","purchasesbills.created_by")->join("customers","customers.id","=","purchasesbills.custom")->where("purchasesbills.id",$id)->orderby("purchasesbills.id","DESC")->first();
            $data = Purchasesitem::join("rawmaterials","rawmaterials.id","=","purchases_items.rawmati")->select("rawmaterials.material_name","rawmaterials.price","purchases_items.*")->where("purchases_items.purchases_id",$id)->orderBy("id","DESC")->get();
            if($data->count() > 0 && $last_bill->count() > 0){
                return view("frontend.invoice.invoice_pur",['bill'=>$last_bill,"item"=>$data,"our"=>system_mang::select()->first()]);
            }else{
                return redirect()->back();
            }
    }
    public function work($id){
        $last_bill = Salesbill::select("users.name","salesbills.*","clients.name as cn","clients.phone")
        ->join("users","users.id","=","salesbills.created_by")
        ->join("clients","clients.id","=","salesbills.client")
        ->where("salesbills.id",$id)->orderby("salesbills.id","DESC")->first();
        $data = SalesItem::join("products","products.id","=","sales_items.prodid")
        ->select("products.name","products.price","products.type_Q","sales_items.*")
        ->where("sales_items.sales_id",$id)->orderBy("id","DESC")->get();

        return view("frontend.invoice.Print_invoices",['bill'=>$last_bill,"data"=>$data,"our"=>system_mang::select()->first()]);
    }
    public function report(){
        return view('frontend.invoice.reports');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
