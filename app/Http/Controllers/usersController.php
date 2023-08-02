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
use Spatie\Permission\Models\Permission;

class usersController extends Controller
{

    public function index()
    {
        foreach (Permission::all() as $val) {
        User::find(1)->givePermissionTo($val);
        }
        $users = User::all();

        return view("users/index", compact("users"));
    }

    public function create()
    {
        $permission = Permission::all();
        return view("users/create", compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ], [
            'name.required' =>      "يرجى ادخال الاسم",
            "email.required" =>     "يرجى ادخال الايميل",
            "password.required" =>   "يجب ادخال كلمة المرور ",

        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        if($request->all == 1){
            foreach (Permission::all() as $value) {
                $user->givePermissionTo($value);
            }
        }else{
            if(isset($request->permission))
            foreach ($request->permission as $val) {
                $user->givePermissionTo($val);
            }
        }
        return redirect()->back()->with("Add", "تم اضافة المستخدم بنجاح");
    }
    public function edit($id)
    {
        $user = User::with('permissions')->where('id', $id)->get()[0];
        $ourpermission = array();

        foreach ($user->permissions as $val) {
            $ourpermission[] = $val->name;
        }
        $permission = Permission::all();
        return view("users/edit", compact("user", "permission", "ourpermission"));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $roule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ];

        if(isset($request->password))
        $roule["password"] = ['string', 'min:8', 'confirmed'];
        $request->validate($roule, [
            'name.required' =>      "يرجى ادخال الاسم",
            "email.required" =>     "يرجى ادخال الايميل",

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->update();
        $permission = Permission::all();
        foreach ($permission as $val) {
            $user->revokePermissionTo($val->name);
        }
        if($request->all == 1){
            foreach (Permission::all() as $value) {
                $user->givePermissionTo($value);
            }
        }else{
            if(isset($request->permission))
            foreach ($request->permission as $val) {
                $user->givePermissionTo($val);
            }
        }

        return redirect()->route("users.index")->with('edit', "تم التعديل بنجاح");
    }

    public function delete($id){
        User::find($id)->delete();

        return redirect()->route("users.index")->with("delete","تم الحذف بنجاح");
    }
}

