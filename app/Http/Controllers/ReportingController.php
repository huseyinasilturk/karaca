<?php

namespace App\Http\Controllers;

use App\Models\ExpenseStatement;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
    public function index()
    {

        $Objective = Objective::where("name", "=", "expenseType")->get()->groupBy("name");

        return view("live.reporting.index",compact("Objective"));

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

    public function income()
    {

        $income = DB::select("
        SELECT MONTH(created_at) as ay, SUM(price) * amount as fiyat
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(NOW())
        GROUP BY MONTH(created_at)
        ");

        return response()->json(["data"=>$income]);
    }
    public function filter2(Request $request)
    {
        $year = $request->year != null ? "AND YEAR(created_at) =". $request->year :" AND YEAR(created_at) = YEAR(NOW())";
        $expense = DB::select("
            SELECT MONTH(created_at) as ay, SUM(price) * amount as fiyat
            FROM income_statements
            WHERE 1=1 ". $year."
            GROUP BY MONTH(created_at)
        ");

        return response()->json(["data"=>$expense]);
    }
    public function filter(Request $request)
    {
        $type = ($request->type != null  ? " AND expense_type_id = ".$request->type  :  "" );
        $year = $request->year != null ? "AND YEAR(expense_date) =". $request->year :" AND YEAR(expense_date) = YEAR(NOW())";
        $expense = DB::select("
            SELECT MONTH(expense_date) as ay, SUM(price) as fiyat
            FROM expense_statements
            WHERE 1=1 ". $year." ". $type."
            GROUP BY MONTH(expense_date)
        ");

        return response()->json(["data"=>$expense]);
    }
}
