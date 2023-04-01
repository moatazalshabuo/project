<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    // public function section()
    // {
    //     return $this->belongsTo('App\Models\sections');
    // }
}
