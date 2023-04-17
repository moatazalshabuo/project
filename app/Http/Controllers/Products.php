<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\rawmaterials;
use App\Models\material_product;
use App\Models\SalesItem;
use Illuminate\Support\Arr;
use App\Models\WorkHand;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;

class Products extends Controller
{
    public function __construct()
    {
        
    }
    public function index(){
        $products = Product::all();
        return view('frontend/products',['product'=>$products]);
    }


    public function add_pro(Request $request){
        $rouls = ['name'=>"required|unique:products,name|max:255","type_Q"=>"required"];
        $massage = ['name.required'=>"اسم الصنف لايمكن ان يكون فارغ",
        'name.unique'=>"اسم الصنف لايمكن ان يتكرر",
        "type_Q.required"=>"نوع الصنف لايمكن ان يكون فارغ"];

        $this->validate($request,$rouls,$massage);
        $data['name'] = $request->name;
        $data['type_Q'] = $request->type_Q;
        $data['price'] = 0;
        return Product::create($data)->id;
        
    }

    public function delete($id){
        $se = SalesItem::select()->where('prodid',$id)->count();
        if($se > 0){
            
            return response()->json(["error"=>" لايمكن حذف صنف موجود في فاتورة مبيعات"], 200);
        }else{
            Product::where(['id'=>$id])->delete();
            return response()->json(["success"=>"تم الحذف بنجاح"], 200);            
        }
    }

    public function editprod(Request $request){
        $data = Product::where(['id'=>$request->id])->get();
        $data = Arr::add($data,"cost",Helper::cost($request->id));
        return $data;
    }

    public function active($id){
        $sales = Product::find($id);
        $sales->status = 1;
        $sales->update();
    }
    public function unactive($id){
        $sales = Product::find($id);
        $sales->status = 0;
        $sales->update();
    }
    public function update(Request $request){
        $rouls = ['name'=>"required|max:255|unique:products,name,".
        $request->id,"price"=>"required|numeric|min:1|max:9999999",
        "type_Q"=>"required"];
        $massage = ['name.required'=>"اسم الصنف لايمكن ان يكون فارغ",
        "price.required"=>"السعر لايمكن ان يكون فارغ",
        'name.unique'=>"اسم الصنف لايمكن ان يتكرر",
        "type_Q.required"=>"نوع الصنف لايمكن ان يكون فارغ"];

        $this->validate($request,$rouls,$massage);
        $products = Product::find($request->id);
        $products->name = $request->name;
        $products->type_Q = $request->type_Q;
        $products->price = $request->price;
        $products->update();
    }
    public function getMatiSel($id){
        $mymaterial = material_product::join("rawmaterials","rawmaterials.id","=","proudct_material.rawid")->select(["rawmaterials.material_name","rawmaterials.hisba_type","proudct_material.*"])
        ->where(['proudct_material.proid'=>$id])->get();
        $ar = array();
        $data = array("myMate"=>"","mate"=>"<option value=''>اختر العنصر</option>");
        foreach($mymaterial as $val){
            array_push($ar,$val->rawid);
            $type = ($val->hisba_type == 1)?"متر":"قطعة";
            $data["myMate"] .= "<li class='list-group-item'>".$val->material_name." / كمية الاستهلاك  : (".floatval($val->quan).") $type <button id='".$val->id."' class='btn btn-danger dele-mate-p float-left'><i class='mdi mdi-delete'></i></button></li>";
        }
        $material = rawmaterials::select()->whereNotIn('id',$ar)->get();
        foreach($material as $val){
            $data["mate"] .= "<option value=".$val->id.">".$val->material_name."</option>"; 
        }
        echo json_encode($data);
        
    }
    public function getWork($id){
        $mymaterial = WorkHand::select()->where(['working_hand.proid'=>$id])->get();
        // $ar = array();
        $data = array("myMate"=>"");
        foreach($mymaterial as $val){
            // array_push($ar,$val->rawid);
            // $type = ($val->hisba_type == 1)?"متر":"قطعة";
            $data["myMate"] .= "<li class='list-group-item'>".$val->name." / السعر ".floatval($val->price)." <button id='".$val->id."' class='btn btn-info edit-work-p float-left'><i class='mdi mdi-transcribe'></i></button> <button id='".$val->id."' class='btn btn-danger dele-work-p float-left'><i class='mdi mdi-delete'></i></button></li>";
        }
        echo json_encode($data);
    }

    public function addWork(Request $request){
        $rouls = ['work_name'=>"required|max:255",
        "price_work"=>"required|numeric|min:1|max:9999999","proid"=>"required"];
        $massage = ["work_name.required"=>"يجب ادخال اسم الخدمة","price_work.required"=>"يجب تحديد سعر الخدمة"];
        $request->validate($rouls,$massage);
        WorkHand::create([
            "name"=>$request->work_name,
            "proid"=>$request->proid,
            "price"=>$request->price_work,
        ]);
    }

    public function addMeta(Request $request){
        $rouls = ['s_name'=>"required",
        "proid"=>"required"];
        $massage = ["s_name.required"=>"يجب اختيار مادة"];
        if(isset($request->quan)){
            $rouls['quan'] = "required|numeric|min:1|max:9999999";
        }else{
            $rouls['length'] = 'required|numeric|min:1|max:9999999';
            $rouls['width'] = 'required|numeric|min:1|max:9999999';
        }
        $quantity = isset($request->quan)?$request->quan:$request->length * $request->width;
        $request->validate($rouls,$massage);
        material_product::create([
            "rawid"=>$request->s_name,
            "proid"=>$request->proid,
            "quan"=>$quantity,
        ]);
    }
    public function delMeta($id){
        $delMate = material_product::find($id);
        $proid = $delMate->proid;
        $delMate->delete();
        echo $proid;
    }
    public function delWork($id){
        $delMate = WorkHand::find($id);
        $proid = $delMate->proid;
        $delMate->delete();
        echo $proid;
    }
    public function editWork($id){
        $delMate = WorkHand::find($id);
        $data = array("name"=>$delMate->name,"price"=>$delMate->price);
        $data['proid'] = $delMate->proid;
        $delMate->delete();
        echo json_encode($data);
    }
    public function get_type($id){
        return rawmaterials::find($id)->hisba_type;
    }

    public function get_type_product($id){
        return Product::find($id)->type_Q;
    }
}
