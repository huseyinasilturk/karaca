<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type_id'];

    public function productFileData()
    {
        return $this->hasMany(FileData::class, 'table_id', 'id')->where('table_name', '=', 'products');
    }

    public function productStock(){
        return $this->hasMany(Stock::class,'product_id','id');
    }

    public function productTypeGet(){
        return $this->hasOne(Objective::class,'id','type_id')->where('name','=','productType');

    }

    public function productCompanyGet()
    {
        return $this->hasMany(ListPrice::class, 'product_id', 'id');
    }

}
