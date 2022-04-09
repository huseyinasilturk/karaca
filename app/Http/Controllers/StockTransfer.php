<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransfer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view("live.stockTransfer.index",compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $test = Stock::select(["c.name AS company_name", "p.name AS product_name","stocks.amount","stocks.purchase_price","stocks.id","stocks.unit_type","stocks.product_id",])
        ->leftJoin("companies as c","c.id" ,"stocks.company_id")
        ->leftJoin("products as p" , "p.id" , "stocks.product_id")
        ->where("amount", "!=" ,0)->get();

        return  response()->json(["data"=>($test)]);
    }

    public function transfer(Request $request)
    {

        $stock = Stock::where("id","=",$request->stock_id)->first();


        $kalanStok = $stock->amount - $request->amount;

        $stock = $stock->where("id","=",$request->stock_id)->update(['amount'=> $kalanStok]);

        Stock::create([
            "purchase_price"=> $request->price,
            "unit_type"=> $request->unit_type,
            "product_id"=> $request->product_id,
            "company_id"=> $request->company_id,
            "amount"=> $request->amount
        ]);

      return redirect()->back();

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
