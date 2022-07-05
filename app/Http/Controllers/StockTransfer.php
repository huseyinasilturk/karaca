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
        if (!auth()->user()->can("stock.transfer")) {
            return back();
        }

        $companies = Company::all();
        return view("live.stockTransfer.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $test = Stock::select(["c.name AS company_name", "p.name AS product_name", "stocks.amount", "stocks.purchase_price", "stocks.id", "stocks.unit_type", "stocks.product_id",])
            ->leftJoin("companies as c", "c.id", "stocks.company_id")
            ->leftJoin("products as p", "p.id", "stocks.product_id")
            ->where("amount", "!=", 0)->get();

        return  response()->json(["data" => ($test)]);
    }

    public function transfer(Request $request)
    {
        $stock = Stock::where("id", "=", $request->stock_id)->first();

        $kalanStok = $stock->amount - $request->amount;

        $stock = $stock->where("id", "=", $request->stock_id)->update(['amount' => $kalanStok]);

        $createStock = Stock::create([
            "purchase_price" => $request->price,
            "unit_type" => $request->unit_type,
            "product_id" => $request->product_id,
            "company_id" => $request->company_id,
            "amount" => $request->amount
        ]);

        if (!$createStock) {
            return response()->json(["message" => "Stok oluştururken bir hata oluştu"], 404);
        }

        return response()->json(["message" => "Stok başarıyla güncellendi"], 201);
    }
}
