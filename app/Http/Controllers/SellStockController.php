<?php

namespace App\Http\Controllers;

use App\Models\IncomeStatement;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // $stocks = DB::select("SELECT COALESCE(SUM(stocks.amount),0) AS stock, products.* FROM products LEFT JOIN stocks ON products.id = stocks.product_id  GROUP BY stocks.product_id")

        DB::enableQueryLog();

        $stocks =  Product::select(["products.*",DB::raw("COALESCE(SUM(stocks.amount),0) as amount"),DB::raw("COALESCE(list_prices.list_price,0) as list_price")])->with("productFileData")->leftjoin("stocks","products.id","stocks.product_id")->leftjoin("list_prices","list_prices.product_id","products.id")->where("list_prices.company_id","=",auth()->user()->company_id)->orWhereNull("list_prices.company_id")->groupBy("stocks.product_id")->get();

        // return $stocks;
        // return  DB::getQueryLog();

        return view("live.sellStock.index",compact("stocks"));
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

        foreach ($request->product as $key => $value) {
            $product = json_decode($value);
            $productCount = $product->adet;
            $stock= Stock::where("product_id",$product->id)->where("amount","!=",0)->orderBy('created_at', 'ASC')->get();
                foreach ($stock as $key => $stock_value) {
                    if ($stock_value->amount < $productCount) {
                        Stock::find($stock_value->id)->update(["amount"=>0]);
                        $productCount = $productCount-$stock_value->amount;
                    }
                    else {
                        Stock::find($stock_value->id)->update(["amount"=>$stock_value->amount-$productCount]);
                        $productCount =$stock_value->amount- $productCount;

                    }
                    if ($productCount<=0) {
                        break;
                    }
                }
                IncomeStatement::create([
                    "product_id"	=> $product->id,
                    "price"	=>$product->price,
                    "amount"	=>$product->adet,
                    "detail"	=>"Ürün Satış İşlemi",
                    "costumer_id"=>$request->costumer
                ]);
        }

        return response()->json(["geriDonus"=>$stock]);
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
