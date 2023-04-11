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
    public function __construct()
    {
        $this->middleware(['manager']);
    }
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
        $roule = [
            'material_name'=>'required|unique:rawmaterials,material_name|max:255',
            'hisba_type'=>'required',
            'price'=>'required|numeric|max:9999999|min:0',
        ];
        if(!isset($request->quantity)){
            $roule['length'] = 'required|numeric|max:9999999|min:0';
            $roule['width'] = 'required|numeric|max:9999999|min:0';
        }else{
            $roule['quantity'] = 'required|numeric|max:9999999|min:0';
        }
        $validtiondata = $request->validate($roule,[
         'material_name.required'=>'يرجى ادخال اسم المادة',
         'material_name.unique'=>'هذه المادة موجدود من قبل!!',
         'hisba_type.required'=>'يرجى ادخال نوع الكمية للمادة',
        //  'quantity.max'=>' الكمية',
         'price.required'=>'يرجى ادخال سعر المادة',
         ]
     );
     $quantity = isset($request->quantity)?$request->quantity:$request->length * $request->width;
             rawmaterials::create([
                 'material_name'=>$request->material_name,
                 'hisba_type'=>$request->hisba_type,
                 'quantity'=>$quantity,
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
            'quantity'=>'required|numeric|max:9999999|min:0|',
            'price'=>'required|numeric|max:9999999|min:0',
        ];
        $message = [
            'material_name.required'=>'يرجى ادخال اسم المادة',
            'material_name.unique'=>'هذه المادة موجدود من قبل!!',
            'hisba_type.required'=>'يرجى ادخال نوع الكمية للمادة',
            'quantity.required'=>'يرجى ادخال نوع الكمية',
            'price.required'=>'يرجى ادخال سعر المادة',
    
            ];
            $request->validate($rouls,$message);
     $rawmaterials = rawmaterials::find($request->id);
     $rawmaterials->material_name=$request->material_name;
     $rawmaterials->hisba_type = $request->hisba_type;
     $rawmaterials->quantity = $request->quantity;
     $rawmaterials->price = $request->price;
     $rawmaterials->update();
    }

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
