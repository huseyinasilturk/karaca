<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id"	,
        "price"	,
        "amount"	,
        "detail"	,
        "company_id"	,
        "customer_id"
    ];
}
