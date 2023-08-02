<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Asset::query();

        if(isset($_GET['name'])){
            $query->where('name',"%".$_GET['name']."%");
            $name = $_GET['name'];
        }

        $data = $query->paginate(10);
        return view('assets.index', compact('data'));
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
            'name' => 'required',
            'value' => 'required|numeric',
        ]);
        if (Treasury::CheckTreasury($request->value)) {
            $asset = new Asset;
            $asset->name = $request->name;
            $asset->value = $request->value;
            $asset->username = Auth::user()->name;
            $asset->save();
            return redirect()->back()->with("success", "تم الحفظ بنجاح");
        } else {
            return redirect()->back()->with("error", "القيمة المدخلة اكبر من قيمة الخزينة");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->back()->with("success", "تم الحذف بنجاح");
    }
}
