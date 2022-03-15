<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $pageConfigs = [
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok"], ['name' => "Stok"]
        ];

        $products = Product::with("productFileData", "productTypeGet")->get();

        $productCategories = Objective::where("name", "productType")->get();

        return view("live.stock.index", compact("products", "pageConfigs", "breadcrumbs", "productCategories"));
    }
}
