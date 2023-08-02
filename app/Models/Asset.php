<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = ["id","name","value","username"];

    public static function somcount($date = null)
    {
        $count = 0;
        if ($date) {
            $count = Asset::select(DB::raw('sum(value)'))
                ->whereBetween('created_at', [$date['from'], $date['to']])->get()[0]->value;
        } else {
            $count = Asset::select(DB::raw('sum(value)'))->get()[0]->value;
        }

        return empty($count) ? 0 : $count;
    }
}
