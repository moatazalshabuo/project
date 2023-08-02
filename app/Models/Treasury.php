<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;

    protected $fillable = ["id","name","amount","capital","type"];

    public static function CheckTreasury($value){
        if(Treasury::find(1)->amount >= $value){
            return true;
        }else{
            return false;
        }
    }
}
