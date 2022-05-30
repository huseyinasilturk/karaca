<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\IncomeStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $income = IncomeStatement::select(["income_statements.*", "products.name", "customers.id as customer_id", "customers.name as customer_name"])->leftjoin("products", "products.id", "=", "income_statements.product_id")->leftjoin("customers", "customers.id", "=", "income_statements.customer_id")->where("company_id", "=", auth()->user()->company_id)->get();
        $customer = Customer::all();

        $totalSum = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) AND company_id =  " . auth()->user()->company_id);

        $totalSumAy = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) AND MONTH(created_at) = MONTH(DATE(NOW()))  AND company_id =  " . auth()->user()->company_id);

        return view("live.income.index", compact("income", "totalSum", "totalSumAy", "customer"));
    }

    public function filter(Request $request)
    {

        DB::enableQueryLog();

        $incomeFilter = IncomeStatement::query();

        $incomeFilter = $incomeFilter->select(["income_statements.*", "products.name", "customers.id as customer_id", "customers.name as customer_name"])->leftjoin("products", "products.id", "=", "income_statements.product_id")->leftjoin("customers", "customers.id", "=", "income_statements.customer_id")->where("company_id", "=", auth()->user()->company_id);

        if ($request->customer != -2) {
            $incomeFilter->where("income_statements.customer_id", "=", $request->customer);
        }
        if ($request->product != -2) {
            $incomeFilter->where("income_statements.product_id", "=", $request->product);
        }
        if ($request->date != null) {
            $incomeFilter->where("income_statements.created_at", "like", "%" . $request->date . "%");
        }

        return response()->json(["income" => $incomeFilter->get()]);
    }

    public function select(Request $request)
    {

        $rapor = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW()))" . ($request->customer != -2 ? " AND income_statements.customer_id" . " = " . $request->customer : "") . ($request->product != -2 ? " AND income_statements.product_id" . " = " . $request->product : "") . ($request->date != null ? " AND income_statements.created_at" . " like " . "'%" . $request->date . "%'" : "") . "
        GROUP BY MONTH(created_at), YEAR(created_at) ");

        return response()->json(["rapor" => $rapor, "test" => $request->all()]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        IncomeStatement::all();
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $Income = IncomeStatement::create([
            "product_id" => -1,
            "price"    => $request->price,
            "amount" =>    1,
            "detail" => $request->detail,
            "customer_id" => $request->costumer,
            "company_id" => auth()->user()->company_id
        ]);

        return response()->json($Income);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!empty($id)) {
            $income = IncomeStatement::find($id);
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
