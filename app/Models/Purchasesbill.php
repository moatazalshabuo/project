<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchasesbill extends Model
{
    use HasFactory;
    protected $fillable = ["id","created_by","tolal","sincere","custom","Residual","status","created_at"];
    protected $table = "purchasesbills";

    public static function somcount($date = null)
    {
        $count = 0;
        if ($date) {
            $count = Purchasesbill::select(DB::raw('sum(tolal) as totel'))
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->totel;
        } else {
            $count = Purchasesbill::select(DB::raw('sum(tolal) as totel'))->get()[0]->totel;

        }

        return empty($count) ? 0 : $count;
    }
}
