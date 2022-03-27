<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockLimitController extends Controller
{
    public function add()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Limit Ekle"]
        ];

        $products = Product::with("productStock")->get();

        // return $products;

        return view("live.stockLimit.add", compact("breadcrumbs", "products"));
    }
}
