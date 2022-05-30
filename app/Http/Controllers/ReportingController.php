<?php

namespace App\Http\Controllers;

use App\Models\ExpenseStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
    public function index()
    {
        return view("live.reporting.index");
    }

    public function expense()
    {

        $expense = DB::select("
        SELECT MONTH(expense_date) as ay, SUM(price) as fiyat
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(NOW())
        GROUP BY MONTH(expense_date)
        ");

        return response()->json(["data"=>$expense]);
    }
}
