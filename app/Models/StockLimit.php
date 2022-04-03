<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLimit extends Model
{
    use HasFactory;

    protected $fillable = ["product_id", "company_id", "limit"];

    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
    public function company()
    {
        return $this->hasOne(Company::class, "id", "company_id");
    }
}
