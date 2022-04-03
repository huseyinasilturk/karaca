<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockLimitRequest;
use App\Models\Product;
use App\Models\StockLimit;
use Illuminate\Http\Request;

class StockLimitController extends Controller
{
    public function index()
    {
        return view("live.stockLimit.index");
    }

    public function add()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Limit Ekle"]
        ];

        $products = Product::with("productStock")->get();

        return view("live.stockLimit.add", compact("breadcrumbs", "products"));
    }

    public function store(StockLimitRequest $request)
    {
        $createLimit = StockLimit::create($request->validated());

        if (!$createLimit) {
            return response()->json(["message" => "Limit oluşturulurken hata oluştu"], 404);
        }

        return response()->json(["message" => "Limit başarıyla oluşturuldu"], 201);
    }

    public function limits()
    {
        $limits = StockLimit::with("product")->get();

        return response()->json($limits, 200);
    }

    public function delete($id)
    {
        $deleteLimit = StockLimit::find($id)->delete();

        if (!$deleteLimit) {
            return response()->json(["message" => "Limit silinirken hata oluştu"], 404);
        }
        return response()->json(["message" => "Limit başarıyla silindi"], 200);
    }
}
