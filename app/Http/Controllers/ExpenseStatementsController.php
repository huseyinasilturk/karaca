<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ExpenseStatement;
use App\Models\IncomeStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseStatementsController extends Controller
{
    public function index()
    {

        $ExpenseStatement = ExpenseStatement::where("company_id", "=", auth()->user()->company_id)->get();
        $customer = Customer::all();

        $totalSum = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) AND company_id =  " . auth()->user()->company_id);

        $totalSumAy = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) AND MONTH(created_at) = MONTH(DATE(NOW()))  AND company_id =  " . auth()->user()->company_id);


        return view("live.ExpenseStatements.index", compact("ExpenseStatement", "totalSum", "totalSumAy", "customer"));
    }

    public function select(Request $request)
    {
        $rapor = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price * expense_statements.amount) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW()))" . ($request->customer != -2 ? " AND expense_statements.customer_id" . " = " . $request->customer : "") . ($request->product != -2 ? " AND expense_statements.product_id" . " = " . $request->product : "") . ($request->date != null ? " AND expense_statements.expense_date" . " like " . "'%" . $request->date . "%'" : "") . "
        GROUP BY MONTH(expense_date), YEAR(expense_date) ");

        return response()->json(["rapor" => $rapor, "test" => $request->all()]);
    }
}
