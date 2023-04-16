<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct()
    {
        
    }
     public function index()
     {
         $user = User::all();
 
         return view('users.index', compact('user'));
     }


     public function update(Request $request)
     {
        $id = $request->id;
        // $this->validate($request,[
        
        //  'section_name' => 'required|max:255|unique:users,name,'.$id,
        //  'description' => 'required',
        // ],
        // [
        //  'section_name.required' => 'يرجى ادخال اسم القسم',
        //  'section_name.regex' => 'القيمة المدخلة في اسم القسم خطأ',
        //  'section_name.unique' => 'اسم القسم مسجل مسبقاً',
        //  'description' => 'يرجى ادخال الوصف للقسم'
        // ]);
 
        $data_update = User::find($id);
        $data_update->update([
         'name'=>$request->name,
         'password' => Hash::make($request['password']),
         'email' => $request->email,
         'user_type' => $request->user_type,

        ]);
        session()->flash('edit','تم تعديل بيانات المستخدم بنجاج');
        return redirect('/users');
     }

    public function destroy(Request $request)
    {
        
        $Products = User::findOrFail($request->pro_id);
        
        if(empty(Purchasesbill::where('created_by',$Products->id)->get())
         && empty(Purchasesitem::where('user_id',$Products->id)->get()) 
         && empty(Salesbill::where('created_by',$Products->id)->get()) 
         && empty(SalesItem::where('user_id',$Products->id)->get())
         && empty(rawmaterials::where('created_by',$Products->id)->get())){
         $Products->delete();
         session()->flash('delete', 'تم حذف المستخدم بنجاح');
         return back();
        }else{
            session()->flash('delete', 'لايمكن حذف المستخدم حاليا سيتسسب ذالك بفقد البيانات');
         return back();
        }
    }


    // public function logout(Request $request) 
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/login');
    // }
}