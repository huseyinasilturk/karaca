<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Company;
use App\Models\ExpenseStatement;
use App\Models\Objective;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $products = Product::with("productFileData", "productTypeGet", "productCompanyGet", "productStock")->get();
        $companies = Company::all();

        $productCategories = Objective::where("name", "productType")->get();
        $unitTypes = Objective::where("name", "unitType")->get();

        return view("live.stock.index", compact("products", "pageConfigs", "breadcrumbs", "productCategories", "unitTypes", "companies"));
    }

    public function store(StockRequest $request)
    {
        $requestData = $request->only("amount", "company_id", "purchase_price", "product_id", "unit_type");
        $createStock = Stock::create($requestData);

        if (!$createStock) {
            return response()->json(["message" => "Stok oluştururken hata oluştu"], 404);
        }

        $product = Product::find($request->product_id);

        $price = $request->amount * $request->purchase_price;

        $createExpense = ExpenseStatement::create([
            "price" => $price,
            "detail" => $product->name . " ürününden " . $request->amount . " adet eklendi.",
            "table_name" => "stocks",
            "table_id" => $createStock->id,
            "company_id" => $request->company_id,
            "expense_date" => date('Y-m-d')
        ]);

        if (!$createExpense) {
            return response()->json(["message" => "Gider oluşturulurken hata oluştu"], 200);
        }

        return response()->json(["message" => "Stoğa başarıyla eklendi"], 201);
    }

    public function filterProducts(Request $request)
    {
        try {
            $products = Product::query();

            if ($request->filled("min_price")) {
                $products = $products->whereRelation("productCompanyGet", "list_price", ">=", $request->min_price);
            }

            if ($request->filled("max_price")) {
                $products = $products->whereRelation("productCompanyGet", "list_price", "<=", $request->max_price);
            }

            if ($request->filled("categories")) {
                $products = $products->whereIn("type_id", $request->categories);
            }

            $products = $products->get()->load("productFileData", "productTypeGet", "productCompanyGet");
            return response()->json($products, 200);
        } catch (\Throwable $e) {
            return response()->json(["message" => $e], 404);
        }
    }
}
