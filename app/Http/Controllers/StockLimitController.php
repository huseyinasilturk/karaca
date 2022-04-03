<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockLimitRequest;
use App\Models\Product;
use App\Models\StockLimit;

class StockLimitController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Listele"]
        ];

        return view("live.stockLimit.index", compact("breadcrumbs"));
    }

    public function add()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Ekle"]
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

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Güncelle"]
        ];

        $stockLimit = StockLimit::find($id);
        $products = Product::with("productStock")->get();


        return view("live.stockLimit.edit", compact("products", "breadcrumbs", "stockLimit"));
    }

    public function update(StockLimitRequest $request, $id)
    {
        $updateLimit = StockLimit::find($id)->update($request->validated());

        if (!$updateLimit) {
            return response()->json(["errors" => ["update" => "Limit güncellenirken hata oluştu"]], 404);
        }

        return response()->json(["message" => "Limit başarıyla güncellendi"], 200);
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
