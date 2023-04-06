<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class system_mang extends Model
{
    use HasFactory;
    protected $fillable=['logo_name','phone','email','logo_photo'];
}
