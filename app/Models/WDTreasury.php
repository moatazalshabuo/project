<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WDTreasury extends Model
{
    use HasFactory;
    protected $fillable = ["title","ammont","type"];

    public static function somcountW($date = null)
    {
        $count = 0;
        if ($date) {
            $count = WDTreasury::select(DB::raw('sum(ammont) as ammont'))->where('type',1)
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->ammont;
        } else {
            $count = WDTreasury::select(DB::raw('sum(ammont) as ammont'))->where('type',1)->get()[0]->ammont;
        }

        return empty($count) ? 0 : $count;
    }

    public static function somcountD($date = null)
    {
        $count = 0;
        if ($date) {
            $count = WDTreasury::select(DB::raw('sum(ammont) as ammont'))->where('type',0)
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->ammont;
        } else {
            $count = WDTreasury::select(DB::raw('sum(ammont) as ammont'))->where('type',0)->get()[0]->ammont;
        }

        return empty($count) ? 0 : $count;
    }
}
