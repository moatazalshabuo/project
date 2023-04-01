<?php

namespace App\Http\Controllers;

use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class RawmaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = rawmaterials::all();
        return view('frontend.rawmaterials', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validtiondata = $request->validate([
         'material_name'=>'required|unique:rawmaterials|max:255',
         'hisba_type'=>'required',
         'quantity'=>'required|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/|min:0',
         'price'=>'required|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/|min:0',
        ],[
         'material_name.required'=>'يرجى ادخال اسم المادة',
         'material_name.unique'=>'هذه المادة موجدود من قبل!!',
         'hisba_type.required'=>'يرجى ادخال نوع الكمية للمادة',
         'quantity.required'=>'يرجى ادخال نوع الكمية',
         'price.required'=>'يرجى ادخال سعر المادة',
 
         ]
     );
             rawmaterials::create([
                 'material_name'=>$request->material_name,
                 'hisba_type'=>$request->hisba_type,
                 'quantity'=>$request->quantity,
                 'price'=>$request->price,
                 'created_by'=>(auth()->user()->name),
             ]);
             session()->flash('Add','تم اضافة المادة بنجاح');
            //  return redirect('/rawmaterials');
    }

    /**
     * Display the specified resource.
     */
    public function getoldprice($id)
    {
        $material = rawmaterials::find($id);
        $data = array("price"=>$material->price,"quantity"=>$material->quantity);
        echo json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return response()->json(rawmaterials::find($id), 200);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        // $input = $request->all();
        $rouls = [
            'material_name'=>"required|max:255|unique:rawmaterials,material_name,".$request->id,
            'hisba_type'=>'required',
            'quantity'=>'required|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/|min:0',
            'price'=>'required|max:999999|regex:/^(([0-9]*)(\.([0-9]+))?)$/|min:0',
        ];
        $message = [
            'material_name.required'=>'يرجى ادخال اسم المادة',
            'material_name.unique'=>'هذه المادة موجدود من قبل!!',
            'hisba_type.required'=>'يرجى ادخال نوع الكمية للمادة',
            'quantity.required'=>'يرجى ادخال نوع الكمية',
            'price.required'=>'يرجى ادخال سعر المادة',
    
            ];
        $this->validate($request,$rouls,$message);
     $rawmaterials = rawmaterials::find($request->id);
     $rawmaterials->material_name=$request->material_name;
     $rawmaterials->hisba_type = $request->hisba_type;
     $rawmaterials->quantity = $request->quantity;
     $rawmaterials->price = $request->price;
     $rawmaterials->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     print_r($id);
    // }
    public function delete($id)
    {
        // print_r($id);
        if(Purchasesitem::where('rawmati',$id)->count() == 0){
            rawmaterials::find($id)->delete();
            session()->flash('Add','تم الحذف المادة بنجاح');
        }else{
            session()->flash('Add','لا يمكن حذف ماده موجوده في فاتورة مشتريات');
        }
        
        return redirect("/rawmaterials");
    }
}
