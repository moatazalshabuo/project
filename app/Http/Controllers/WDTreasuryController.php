<?php

namespace App\Http\Controllers;

use App\Models\WDTreasury;
use Illuminate\Http\Request;

class WDTreasuryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WDTreasury::all();
       return view("treasury/wd",compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WDTreasury $wDTreasury)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WDTreasury $wDTreasury)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WDTreasury $wDTreasury)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wDTreasury = WDTreasury::find($id);
        $wDTreasury->delete();
        return redirect()->back()->with("success","تم الحذف بنجاح");
    }
}
