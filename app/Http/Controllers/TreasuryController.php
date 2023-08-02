<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Exchange;
use App\Models\pay_receipt;
use App\Models\Purchasesbill;
use App\Models\rawmaterials;
use App\Models\Salesbill;
use App\Models\Treasury;
use App\Models\WDTreasury;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    public function index()
    {
        $w =      WDTreasury::somcountW();
        $d =      WDTreasury::somcountD();
        $asset      =   Asset::somcount();
        $pay =    pay_receipt::somcount();
        $exc =      Exchange::somcountC();
        $exa =      Exchange::somcountA();
        $sales =    Salesbill::somcount();
        $prus = Purchasesbill::somcount();
        $treasury =     Treasury::find(1);
        $raw = round(rawmaterials::somcount(),2);
        return view("Treasury/index", compact('treasury',"w","d",'asset',"pay","exc",'exa','sales',"prus","raw"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ["required", "max:30"],
            'amount' => ["required", "min:0"],
            "capital" => ["required", "min:0"]
        ]);

        Treasury::create([
            'name' => $request->name,
            "amount" => $request->amount,
            "capital" => $request->capital,
            "type" => 1
        ]);
        return redirect()->back();
    }

    public function deposit(Request $request)
    {
        $request->validate([
            "title" => ['required', "max:25"],
            "ammont" => ["required", 'min:0'],
            "type" => ["required"]
        ]);
        $treasury = Treasury::find(1);
        if ($request->type == 1) {
            if ($request->ammont < $treasury->amount) {
                WDTreasury::create([
                    "title"=>$request->title,
                    "ammont"=>$request->ammont,
                    "type"=>$request->type
                ]);
            }else{
                return redirect()->back()->with("error","القيمة اكبر من المجود في الخزينة");
            }
        }else{
            WDTreasury::create([
                "title"=>$request->title,
                "ammont"=>$request->ammont,
                "type"=>$request->type
            ]);
        }
        return redirect()->back()->with('success',"تم الحفظ بنجاح");
    }
}
