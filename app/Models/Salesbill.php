<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesbill extends Model
{
    use HasFactory;
    protected $fillable = ["id","client","created_by","tolal","sincere","Residual","status","created_at"];
    protected $table = "salesbills";
}
