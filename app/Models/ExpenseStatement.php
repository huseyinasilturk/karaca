<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseStatement extends Model
{
    use HasFactory;

    protected $fillable = ["price", "detail", "table_name", "table_id", "company_id", "expense_date", "expense_type_id"];

}
