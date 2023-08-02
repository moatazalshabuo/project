<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\pay_receipt;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countsals = array(Salesbill::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count(), Salesbill::select()->count());
        $countpur = array(Purchasesbill::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count(), Purchasesbill::select()->count());
        $countpay = array(pay_receipt::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count(), pay_receipt::select()->count());
        $countexc = array(Exchange::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count(), Exchange::select()->count());

        $sales_bill = Salesbill::select("salesbills.*", "clients.name", "clients.phone")->where("status", 0)->join("clients", "clients.id", "=", "salesbills.client")->get();
        $sales_bills_process = array();
        $sales_bills_done = array();
        foreach ($sales_bill as $bill) {
            foreach (SalesItem::where('sales_id', $bill['id'])->get() as $item) {
                if ($item['status'] == 0) {
                    array_push($sales_bills_process, $bill);
                }
                if ($item['status'] == 1) {
                    array_push($sales_bills_done, $bill);
                }
            }
        }
        //    print_r($sales_bills_done);die();

        $raw = rawmaterials::select()->where("quantity", "<", 15)->get();
        return view('frontend/home', [
            'countsals' => $countsals,
            'countpur' => $countpur,
            'countpay' => $countpay,
            'countexc' => $countexc,
            "bills_done" => $sales_bills_done,
            "bill_process" => $sales_bills_process, 'raw' => $raw
        ]);
    }

    public function Register(Request $request)
    {
        return view('frontend.register');
    }
    public function store(Request $request)
    {


        $roule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['min:8'],
            'password_confirmation' => 'required_with:password|same:password|min:8',
            "user_type" => ["required"]
        ];
        $message = [
            'name.required' => "يجب ادخال الاسم ",
            'name.string' => "يجب ادخال الاسم نصي ",
            'name.max:255' => "الاسم اطول من المطلوب",
            'emil.required' => "يجب ادخال الايميل ",
            'email.string' => "يجب ادخال الايميل نصي ",
            'email.max:255' => "الايميل اطول من المطلوب",
            'email.unique' => "هذا الايميل مسجل مسبقا",
            'password_confirmation.required' => "يجب ادخال كلمة المرور ",
            'password.min' => "كلمةالمرور يجب ان تكون اطول من 8",
            'password_confirmation.min' => "كلمةالمرور يجب ان تكون اطول من 8",
            'password_confirmation.same' => "كلمة المرور يجب ان تكون مطابقة",
            'user_type.required' => "يجب ادخال نوع المستخدم"
        ];
        $request->validate($roule, $message);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "user_type" => $request->user_type
        ]);
        return redirect()->route('users.index')->with('add', "تم الاضافة بنجاح");
    }
    public function deleteuser($id)
    {
        $Products = User::find($id);
        $c = Purchasesbill::where('created_by', $Products->id)->count() + Purchasesitem::where('user_id', $Products->id)->count() + Salesbill::where('created_by', $Products->id)->count() + SalesItem::where('user_id', $Products->id)->count() + rawmaterials::where('created_by', $Products->id)->count();
        // echo $c;die();
        if ($c == 0) {
            $Products->delete();
            return redirect()->route('users.index')->with('delete', 'تم الحذف بنجاح');
        } else {
            return redirect()->route('users.index')->with('delete', 'لايمكن حذف المستخدم حاليا سيتسسب ذالك بفقد البيانات');
        }
    }
    public function statususer($id)
    {
        $user = User::find($id);
        if ($user->status) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }
        $user->update();
        return redirect()->route('users.index')->with('delete', 'تم التعديل بنجاح');
    }
    public function account(Request $request)
    {
        if (isset($request->account)) {
            if ($request->account == 1) {
                $data  = client::select('clients.name', "clients.phone", DB::raw("SUM(salesbills.sincere) as sincere"), DB::raw("SUM(salesbills.Residual) as Residual"))->join("salesbills", "salesbills.client", "clients.id")->groupBy("clients.id")->get();
            } else {
                $data  = Customer::select('customers.name', "customers.phone", DB::raw("SUM(purchasesbills.sincere) as sincere"), DB::raw("SUM(purchasesbills.Residual) as Residual"))->join("purchasesbills", "purchasesbills.custom", "customers.id")->groupBy("customers.id")->get();
            }
        } else {
            $data = array();
        }
        return view('frontend.accunt', ['data' => $data]);
    }

    public function report_material()
    {

        return view("frontend.report-material");
    }
}
