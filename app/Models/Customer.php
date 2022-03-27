<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ["name", "customer_type_id"];

    public function type()
    {
        return $this->hasOne(Objective::class, "id", "customer_type_id");
    }
}
