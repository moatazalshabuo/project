<?php

namespace App\Http\Controllers;

use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\Salesbill;
use App\Models\SalesItem;
use Illuminate\Http\Request;

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
            if(!empty($data) && !empty($last_bill)){
                return view("frontend.invoice.invoice_bill1",['bill'=>$last_bill,"item"=>$data]);
            }else{
                return redirect()->back();
            }
    }

    public function invicepur($id)
    {
        // if(view()->exists($id)){

            $last_bill = Purchasesbill::select("users.name","purchasesbills.*","customers.name as cn","customers.phone")->join("users","users.id","=","purchasesbills.created_by")->join("customers","customers.id","=","purchasesbills.custom")->where("purchasesbills.id",$id)->orderby("purchasesbills.id","DESC")->first();
            $data = Purchasesitem::join("rawmaterials","rawmaterials.id","=","purchases_items.rawmati")->select("rawmaterials.material_name","rawmaterials.price","purchases_items.*")->where("purchases_items.purchases_id",$id)->orderBy("id","DESC")->get();
            if(!empty($data) && !empty($last_bill)){
                return view("frontend.invoice.invoice_pur",['bill'=>$last_bill,"item"=>$data]);
            }else{
                return redirect()->back();
            }
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
