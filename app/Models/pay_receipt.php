<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pay_receipt extends Model
{
    use HasFactory;

    protected $table = "pay_receipt";
    protected $fillable = ['id', 'bill_id', "client_id", "price", "created_by", "created_at"];


    public static function somcount($date = null)
    {
        $count = 0;
        if ($date) {
            $count = pay_receipt::select(DB::raw('sum(pay_receipt.price)'))
                ->whereBetween('pay_receipt.created_at', [$date['from'], $date['to']])->get()[0]->price;
        } else {
            $count = pay_receipt::select(DB::raw('sum(pay_receipt.price) as price'))->get()[0]->price;
        }

        return empty($count) ? 0 : $count;
    }
}
