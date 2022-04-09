<?php

namespace App\Http\Controllers;

use App\Models\IncomeStatement;
use Illuminate\Http\Request;
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

        $income = IncomeStatement::select(["income_statements.*","products.name"])->leftjoin("products","products.id","=","income_statements.product_id")->get();
        $totalSum = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) ");

        $totalSumAy = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW())) AND MONTH(created_at) = MONTH(DATE(NOW()))  ");

        return view("live.income.index",compact("income","totalSum","totalSumAy"));

    }

    public function select()
    {

        $rapor = DB::select("SELECT MONTH(created_at) AS mouth, YEAR(created_at) AS YEAR, SUM(income_statements.price * income_statements.amount) AS totalSum
        FROM income_statements
        WHERE YEAR(created_at) = YEAR(DATE(NOW()))
        GROUP BY MONTH(created_at), YEAR(created_at)");

        return response()->json($rapor);
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
            "product_id" => -1 ,
            "price"	=> $request->price ,
            "amount" =>	1 ,
            "detail"	=> $request->detail ,
            "costumer_id" => $request->costumer
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
        //
    }
}
