<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasesitem extends Model
{
    use HasFactory;
    protected $fillable = ['id','rawmati',"purchases_id","sales_id","qoun","descont","total","user_id","created_at"];
    protected $table = "purchases_items";

}
