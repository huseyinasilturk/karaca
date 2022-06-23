<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "price",
        "amount",
        "detail",
        "company_id",
        "sell_person_id",
        "customer_id",
        "sales_id"
    ];
}
