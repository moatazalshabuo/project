<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salesbill extends Model
{
    use HasFactory;
    protected $fillable = ["id","client","created_by","total","sincere","Residual","status","created_at"];
    protected $table = "salesbills";

    public static function somcount($date = null)
    {
        $count = 0;
        if ($date) {
            $count = Salesbill::select(DB::raw('sum(total) as total'))
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->total;
        } else {
            $count = Salesbill::select(DB::raw('sum(total) as total'))->get()[0]->total;
        }

        return empty($count) ? 0 : $count;
    }
}
