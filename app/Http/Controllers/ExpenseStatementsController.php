<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ExpenseStatement;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseStatementsController extends Controller
{
    public function index()
    {

        $ExpenseType = Objective::where("name", "=", "expenseType")->get();
        // $ExpenseStatement = ExpenseStatement::where("company_id", "=", auth()->user()->company_id)->get();
        // SELECT * FROM expense_statements e INNER JOIN objectives o ON e.expense_type_id = o.id
        // SELECT * FROM expense_statements AS es JOIN objectives o ON es.expense_type_id = o.id

        $ExpenseObjective = DB::select("SELECT * FROM expense_statements AS e INNER JOIN objectives AS o ON e.expense_type_id = o.id");
        // dd($ExpenseObjective);

        $totalSum = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW())) AND company_id =  " . auth()->user()->company_id);

        $totalSumAy = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW())) AND MONTH(expense_date) = MONTH(DATE(NOW()))  AND company_id =  " . auth()->user()->company_id);


        return view("live.ExpenseStatements.index", compact("ExpenseObjective", "totalSum", "totalSumAy", "ExpenseType"));
    }

    public function select(Request $request)
    {
        $rapor = DB::select("SELECT MONTH(expense_date) AS mouth, YEAR(expense_date) AS YEAR, SUM(expense_statements.price) AS totalSum
        FROM expense_statements
        WHERE YEAR(expense_date) = YEAR(DATE(NOW()))"  . ($request->date != null ? " AND expense_statements.expense_date" . " like " . "'%" . $request->date . "%'" : "") . "
        GROUP BY MONTH(expense_date), YEAR(expense_date) ");

        return response()->json(["rapor" => $rapor, "test" => $request->all()]);
    }

    public function filter(Request $request)
    {

        DB::enableQueryLog();

        $incomeFilter = ExpenseStatement::query();

        $incomeFilter = $incomeFilter->join('objectives', 'expense_statements.expense_type_id', '=', 'objectives.id');

        $incomeFilter = $incomeFilter->where("company_id", "=", auth()->user()->company_id);

        if ($request->date != null) {
            $incomeFilter->where("expense_statements.created_at", "like", "%" . $request->date . "%");
        }
        $incomeFilter = $incomeFilter->get();

        return response()->json(["income" => $incomeFilter]);
    }

    public function store(Request $request)
    {

        $Expense = ExpenseStatement::create([
            "price"    => $request->price,
            "detail" => $request->detail,
            "expense_type_id" => $request->expenseType,
            "table_name" => "expense",
            "expense_date" => DATE(NOW()),
            "company_id" => auth()->user()->company_id
        ]);

        return response()->json($Expense);
    }

    public function destroy($id)
    {
        if (!empty($id)) {
            $income = ExpenseStatement::find($id);
            if ($income) {
                $income->delete();
                return response()->json(['message' => 'Remove Successful :)', 'status' => 202]);
            } else {
                return response()->json(['hata' => 'Remove Failed :/', 'status' => 405]);
            }
        } else {
            return response()->json(['hata' => 'Remove Failed :/', 'status' => 400]);
        }
    }
}
