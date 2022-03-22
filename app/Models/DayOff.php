<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    use HasFactory;

    protected $fillable = ["personal_id", "start_date", "end_date", "detail", "day"];

    public function person()
    {
        return $this->hasOne(User::class, "id", "personal_id");
    }
}
