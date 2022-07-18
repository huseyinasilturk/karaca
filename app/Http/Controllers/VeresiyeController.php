<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Objective;
use App\Models\Product;
use App\Models\veresiye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeresiyeController extends Controller
{
    public function index()
    {

        $ExpenseType = Objective::where("name", "=", "veresiyeTipi")->get();
        // $ExpenseStatement = ExpenseStatement::where("company_id", "=", auth()->user()->company_id)->get();
        // SELECT * FROM expense_statements e INNER JOIN objectives o ON e.expense_type_id = o.id
        // SELECT * FROM expense_statements AS es JOIN objectives o ON es.expense_type_id = o.id

        $ExpenseObjective = DB::select("SELECT e.id as aid , e.* , o.* FROM expense_statements AS e LEFT JOIN objectives AS o ON e.expense_type_id = o.id");
        $musteriler = Customer::all();
        $totalSum = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW())) AND 1 = 2 and company_id =  " . auth()->user()->company_id);

        $totalSumAy = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW())) AND MONTH(expense_date) = MONTH(DATE(NOW()))  AND company_id =  " . auth()->user()->company_id);

        return view("live.veresiye.index", compact("ExpenseObjective", "totalSum", "totalSumAy", "ExpenseType","musteriler"));
    }

    public function store(Request $request)
    {

        veresiye::create($request->all());


        dd($request->all());
    }
}
