<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHand extends Model
{
    use HasFactory;
    protected $table= "working_hand";
    protected $fillable = ['id','name','proid','price'];
}
