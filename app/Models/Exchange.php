<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exchange extends Model
{
    use HasFactory;
    protected $table = "exchange_receipt";
    protected $fillable = ["id", "desc", "bill_id", "type", "price", "created_by", "created_at"];

    public static function somcountC($date = null)
    {
        $count = 0;
        if ($date) {
            $count = Exchange::select(DB::raw('sum(price) as price'))->where("type",0)
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->price;
        } else {
            $count = Exchange::select(DB::raw('sum(price) as price'))->where("type",0)->get()[0]->price;
        }
        return empty($count) ? 0 : $count;
    }
    public static function somcountA($date = null)
    {
        $count = 0;
        if ($date) {
            $count = Exchange::select(DB::raw('sum(price) as price'))->where("type","!=",0)
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->price;
        } else {
            $count = Exchange::select(DB::raw('sum(price) as price'))->where("type","!=",0)->get()[0]->price;
        }
        return empty($count) ? 0 : $count;
    }
}
