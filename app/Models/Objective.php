<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ["name","number1", "number2", "number3", "add_user_id","text1", "text2", "text3"];

}
