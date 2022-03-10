<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','type_id','list_price'];

    public function productFileData(){
        return $this->hasMany(FileData::class,'table_id','id')->where('table_name','=','product');
    }

    public function productType(){
        return $this->hasOne(Objective::class,'id','type_id')->where('name','=','productType');
    }
}
