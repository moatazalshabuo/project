<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;
    protected $fillable = ['id','prodid',"qoun","sales_id","count","length","width","descont","descripe","new_price","total","user_id","created_at"];
    protected $table = "sales_items";
}
