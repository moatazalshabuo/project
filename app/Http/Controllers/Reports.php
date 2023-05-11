<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\pay_receipt;
use App\Models\Product;
use App\Models\Purchasesbill;
use App\Models\Purchasesitem;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use PDO;
use Illuminate\Support\Facades\DB;

class Reports extends Controller
{
    public function __construct(Request $request)
    {
    }

    //
    public function pay_index()
    {
        # code...
        $query = pay_receipt::query();
        $query->select("users.name", "clients.name as cl_name", "clients.phone", "pay_receipt.*")
            ->leftJoin('salesbills', function ($join) {
                $join->on('salesbills.id', '=', 'pay_receipt.bill_id');
            })->leftJoin("clients", function ($join) {
                $join->on('clients.id', '=', 'pay_receipt.client_id')
                    ->orOn("salesbills.client", "=", "clients.id");
            })->join("users", "users.id", "=", "pay_receipt.created_by")->where("pay_receipt.created_at", "like", "%" . date("Y-m-d") . "%");
        $client = client::all();
        return view("frontend/pay_report", ['client' => $client,'data'=>$query->get()]);
    }
    public function search_pay(Request $request)
    {
        $where = array();
        $data = array();
        # code...
        if (isset($request->client)) {
            $where['client'] = $request->client;
        }
        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $where['from'] = $request->from;
            $where['to'] = $request->to;
        }
        $query = pay_receipt::query();
        $query->select("users.name", "clients.name as cl_name", "clients.phone", "pay_receipt.*")
            ->leftJoin('salesbills', function ($join) {
                $join->on('salesbills.id', '=', 'pay_receipt.bill_id');
            })->leftJoin("clients", function ($join) {
                $join->on('clients.id', '=', 'pay_receipt.client_id')
                    ->orOn("salesbills.client", "=", "clients.id");
            })->join("users", "users.id", "=", "pay_receipt.created_by");

        if (isset($where['client']) && isset($where['from']) && isset($where['to'])) {

            $query->whereBetween('pay_receipt.created_at', [$where['from'], $where['to']])
                ->where(["salesbills.client" => $where['client']]);
            $query->orWhere(["pay_receipt.client_id" => $where['client'],]);
        } elseif (isset($where['client'])) {
            //"pay_receipt.client_id"=>$where['client'],
            $query->where(["salesbills.client" => $where['client']]);
            $query->orWhere(["pay_receipt.client_id" => $where['client'],]);
        } elseif (isset($where['from']) && isset($where['from'])) {

            $query->whereBetween('pay_receipt.created_at', [$where['from'], $where['to']]);
        }
        //    print_r($query->get());die();
        // return redirect()->route('pay_index')->with('data', $query->get());
        $client = client::all();
        return view("frontend/pay_report", ['client' => $client,'data'=> $query->get()]);
    }

    public function delete_pay($id)
    {
        $raw = pay_receipt::find($id);
        $price = $raw->price;
        $bills = Salesbill::select("id")->where(["client" => $raw->client_id, "status" => '0'])->where("sincere", ">", "0")->orderBy("id", "DESC")->get();
        foreach ($bills as $val) {
            $sal = Salesbill::find($val->id);
            if ($price > 0) {
                if ($price <= $sal->sincere) {
                    $sal->Residual = $sal->Residual + $price;
                    $sal->sincere = $sal->sincere - $price;
                    $sal->update();
                    $price = 0;
                } else {
                    $price = $price - $sal->sincere;
                    $sal->Residual = $sal->sincere + $sal->Residual;
                    $sal->sincere = 0;
                    $sal->update();
                }
            }
        }
        $raw->delete();
        return redirect()->route('pay_index')->with('success', "تم الحذف بنجاح");
    }

    public function exc_index()
    {
        # code...
        $client = Customer::all();
        $data = Exchange::select("users.name", "exchange_receipt.*")->leftJoin('purchasesbills', "purchasesbills.id", "=", "exchange_receipt.bill_id")
            ->join("users", "users.id", "=", "exchange_receipt.created_by")
            ->where("exchange_receipt.created_at", "like", "%" . date("Y-m-d") . "%")->get();

        return view("frontend/Exchange_report", ["data" => $data, 'custom' => $client]);
    }
    public function search_exc(Request $request)
    {
        $client = Customer::all();
        $query = Exchange::query();
        $query->select("users.name", "exchange_receipt.*")
            ->leftJoin('purchasesbills', "purchasesbills.id", "=", "exchange_receipt.bill_id")
            ->join("users", "users.id", "=", "exchange_receipt.created_by");
        $where = array();
        
        # code...
        if (isset($request->custom)) {
            $where['custom'] = $request->custom;
        }
        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $where['from'] = $request->from;
            $where['to'] = $request->to;
        }
        if (isset($where['custom']) && isset($where['from']) && isset($where['to'])) {
            $data = $query->whereBetween('exchange_receipt.created_at', [$where['from'], $where['to']])->where("custom", $where['custom']);
        }
        if (isset($where['custom'])) {
            $data = $query->where("custom", $where['custom']);
        }
        if (isset($request->descripe)) {
            $data = $query->where("desc", "like", "%$request->descripe%");
        }
        if (isset($where['from']) && isset($where['from'])) {
            $data = $query->whereBetween('exchange_receipt.created_at', [$where['from'], $where['to']]);
        }

        $data = $query->where("type",$request->type_ex);
        return view("frontend/Exchange_report", ["data" => $data->get(), 'custom' => $client]);
    }

    public function delete_exc($id)
    {
        // echo $id;die();
        $raw = Exchange::find($id);
        if ($raw->type == 0) {
            $salesbill = Purchasesbill::find($raw->bill_id);
            $salesbill->sincere = $salesbill->sincere - $raw->price;
            $salesbill->Residual = $salesbill->Residual + $raw->price;
            $salesbill->update();
        }
        $raw->delete();
        return redirect()->route('exc_index')->with('success', "تم الحذف بنجاح");
    }
    public function sales_index()
    {
        # code...
        $user = User::all();

        return view("frontend/sales_report", ['user' => $user]);
    }
    public function search_sales(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...

        if ($request->status != 2) {
            $where['salesbills.status'] = $request->status;
        }
        if (isset($request->user)) {
            $where['salesbills.created_by'] = $request->user;
        }
        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }

        if (isset($date['from']) && isset($date['to'])) {
            $data = Salesbill::select("users.name", "salesbills.*")
                ->join("users", "users.id", "=", "salesbills.created_by")->where($where)->whereBetween('salesbills.created_at', [$date['from'], $date['to']])->get();
        } else {
            $data = Salesbill::select("users.name", "salesbills.*")->join("users", "users.id", "=", "salesbills.created_by")->where($where)->get();
        }

        return redirect()->route('sales_index')->with('data', $data);
    }

    public function pur_index()
    {
        # code...
        $user = User::all();

        return view("frontend/purs_report", ['user' => $user]);
    }
    public function search_pur(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...

        if ($request->status != 2) {
            $where['purchasesbills.status'] = $request->status;
        }
        if (isset($request->user)) {
            $where['purchasesbills.created_by'] = $request->user;
        }
        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }

        if (isset($date['from']) && isset($date['to'])) {
            $data = Purchasesbill::select("users.name", "purchasesbills.*")->join("users", "users.id", "=", "purchasesbills.created_by")->whereBetween('purchasesbills.created_at', [$date])->get();
        } else {
            $data = Purchasesbill::select("users.name", "purchasesbills.*")->join("users", "users.id", "=", "purchasesbills.created_by")->where($where)->get();
        }
        return redirect()->route('pur_index')->with('data', $data);
    }

    public function moveprod_index()
    {
        # code...
        $product = Product::all();

        return view("frontend/move_product", ['product' => $product]);
    }
    public function search_moveprod(Request $request)
    {
        $where = array();
        $date = array();
        $data = array();
        # code...
        $request->validate([
            'product' => "required"
        ], ['product.required' => "يرجى اختيار صنف"]);
        if (isset($request->product)) {
            $where['sales_items.prodid'] = $request->product;
        }
        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }

        if (isset($date['from']) && isset($date['to'])) {
            $data = SalesItem::select("products.name", "sales_items.*", "users.name as username")->join("users", "users.id", "=", "sales_items.user_id")->join("products", "products.id", "=", "sales_items.prodid")->whereBetween('sales_items.created_at', [$date])->get();
        } else {
            $data = SalesItem::select("products.name", "sales_items.*", "users.name as username")->join("users", "users.id", "=", "sales_items.user_id")->join("products", "products.id", "=", "sales_items.prodid")->where($where)->get();
        }
        return redirect()->route('moveprod_index')->with('data', $data);
    }

    public function moveraw_index()
    {
        # code...
        $product = rawmaterials::all();

        return view("frontend/move_rawmat", ['product' => $product]);
    }
    public function search_moveraw(Request $request)
    {
        // $where = array();
        $date = array();
        $data1 = array();
        // $data2 = array();
        $data = array();
        # code...

        $request->validate([
            'product' => "required"
        ], ['product.required' => "يرجى اختيار المادة"]);
        $raw = $request->product;

        if (isset($request->from)) {
            $request->validate([
                'to' => "required"
            ]);
            $date['from'] = $request->from;
            $date['to'] = $request->to;
        }
        //    $i=0;
        $prus = Purchasesitem::query();
        $prus->select(
            DB::raw("min(rawmaterials.material_name) as material_name"),
            DB::raw("min(rawmaterials.id) as rawm"),
            DB::raw("sum(purchases_items.`qoun`) as qaunt"),
            DB::raw("min(purchases_items.created_at) as created_at"),
            DB::raw("purchases_items.purchases_id"),
            DB::raw("min(users.name) as username")
        )
            ->join("users", "users.id", "=", "purchases_items.user_id")
            ->join("rawmaterials", "rawmaterials.id", "=", "purchases_items.rawmati")
            ->where('purchases_items.rawmati', $raw);

        $prus1 = SalesItem::query();

        $prus1->select(DB::raw("min(sales_items.sales_id) as sales_id"),
        DB::raw("sum(sales_items.qoun * proudct_material.quan) as qaunt"),
        DB::raw("min(sales_items.created_at) as created_at"),
        DB::raw("min(users.name) as name"),
        DB::raw("min(rawmaterials.material_name) as material_name"),
        DB::raw("min(rawmaterials.id) as rawm"))
            ->join('proudct_material', "proudct_material.proid", "=", "sales_items.prodid")
            ->join("rawmaterials", "rawmaterials.id", "=", "proudct_material.rawid")
            ->join("users", "users.id", "=", "sales_items.user_id")
            ->where('proudct_material.rawid', $raw);

        if (isset($date['from']) && isset($date['to'])) {

            $prus->whereBetween('purchases_items.created_at', [$date]);

            $prus1->whereBetween('sales_items.created_at', [$date]);
        }
        if ($prus->count() > 0 || $prus1->count() > 0) {
            foreach ($prus->groupBy(["purchases_items.purchases_id"])->get() as $val) {
                array_push(
                    $data1,
                    [
                        'id_bill' => $val->purchases_id,
                        'name' => $val->material_name,
                        'rawid' => $val->rawm,
                        "qoa" => $val->qaunt,
                        'created_at' => $val->created_at,
                        "username" => $val->username,
                        "type" => 1
                    ]
                );
            }
            foreach ($prus1->groupBy(["sales_items.sales_id", "rawmaterials.material_name"])->get() as $val) {
                array_push(
                    $data1,
                    [
                        'id_bill' => $val->sales_id,
                        'name' => $val->material_name,
                        'rawid' => $raw,
                        "qoa" => $val->qaunt,
                        'created_at' => $val->created_at,
                        "username" => $val->name,
                        "type" => 2
                    ]
                );
            }
            $data = collect($data1)->sortBy('created_at')->reverse()->toArray();
            //    print_r($data);die();
        }
        return redirect()->route('moveraw_index')->with('data', $data);
    }
}
