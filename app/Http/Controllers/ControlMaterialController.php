<?php

namespace App\Http\Controllers;

use App\Models\ControlMaterial;
use App\Models\rawmaterials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_add()
    {
        $raws = rawmaterials::all();
        $cm = ControlMaterial::with("raw")->where('type', 1)->get();
        return view('rawmaterial/add_quantity', compact('raws', "cm"));
    }

    public function index_min()
    {
        $raws = rawmaterials::all();
        $cm = ControlMaterial::with("raw")->where('type', 0)->get();
        return view('rawmaterial/min_quantity', compact('raws', 'cm'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raw_id' => ['required'],
            "quantity" => ['required'],
        ]);
        $raw = rawmaterials::find($request->raw_id);

        $quantity = $request->quantity / ($raw->hiegth * $raw->width);

        if ($request->type == 0 && $raw->quantity < $request->quantity) {

            return redirect()->back()->with("error","الكمية المراد ازالتها غير متوفرة");

        } else {

            ControlMaterial::create([
                'raw_id' => $request->raw_id,
                "quantity" => $quantity,
                "type" => $request->type,
                "created_by" => Auth::user()->name
            ]);
        }

        return redirect()->back()->with('add', 'تمت العملية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ControlMaterial $controlMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ControlMaterial $controlMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ControlMaterial $controlMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ControlMaterial::find($id)->delete();

        return redirect()->back()->with("delete", "تم الحذف بنجاح");
    }
}
