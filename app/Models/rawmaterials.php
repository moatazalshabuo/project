<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class rawmaterials extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        'material_name',
        'hisba_type',
        'quantity',
        'price',
        'created_by',
    ];
    protected $table = "rawmaterials";
    public static function somcount($date = null)
    {
        $count = 0;
        if ($date) {
            $count = rawmaterials::select(DB::raw('sum(price*quantity) as total'))
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->total;
        } else {
            $count = rawmaterials::select(DB::raw('sum(price*quantity) as total'))->get()[0]->total;
        }

        return empty($count) ? 0 : $count;
    }
}
