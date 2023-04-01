<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material_product extends Model
{
    use HasFactory;
    protected $fillable = ["id","rawid","proid","quan"];
    
    protected $table = "proudct_material";
}
