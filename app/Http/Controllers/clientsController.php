<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\client;
use App\Models\Salesbill;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Auth;


class clientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = client::all();

        return view('clientss.index', compact('user'));
    }
    public function store(Request $request)
    {

        $input = $request->all();
        $validtiondata = $request->validate(
            [
                'name' => 'required',
                'phone' => 'required',
                

            ],
            [
                'name.required' => 'يرجى ادخال اسم الزبون',
                'phone.required' => 'يرجى ادخال رقم هاتف الزبون',
               
            ]
        );
        client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'adress' => $request->adress,
        ]);
        session()->flash('Add', 'تم اضافة الزبون بنجاح');
        return redirect('/clients');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data_update = client::find($id);
        $data_update->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'adress' => $request->adress,


        ]);
        session()->flash('edit', 'تم تعديل بيانات الزبون بنجاج');
        return redirect('/clients');
    }

    public function destroy(Request $request)
    {
        $Products = client::findOrFail($request->pro_id);
        $sla = Salesbill::where("client",$Products->id)->count();
        if($sla == 0){
        $Products->delete();
        session()->flash('delete', 'تم حذف بيانات الزبون بنجاح');
        return back();
    }else{
        session()->flash('delete', 'لم يتم الحذف توجد فواتير مسجله باسم الزبون');
        return back();
    }

        
    }

}
