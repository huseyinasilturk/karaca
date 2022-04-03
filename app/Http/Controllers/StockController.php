<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Company;
use App\Models\ExpenseStatement;
use App\Models\Objective;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
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
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok"], ['name' => "Ekle"]
        ];

        $products = Product::with("productFileData", "productTypeGet", "productCompanyGet", "productStock")->get();
        $companies = Company::all();

        $productCategories = Objective::where("name", "productType")->get();
        $unitTypes = Objective::where("name", "unitType")->get();

        return view("live.stock.index", compact("products", "pageConfigs", "breadcrumbs", "productCategories", "unitTypes", "companies"));
    }

    public function store(StockRequest $request)
    {

        $product = Product::find($request->product_id);

        // Stokta üründen, o fiyata var mı
        $stockExists = Stock::where("product_id", $product->id)->where("purchase_price", $request->purchase_price)->first();

        // Gidere kaydedilecek fiyatı hesapla
        $price = $request->amount * $request->purchase_price;

        // Eğer varsa o ürünün adedini güncelle ve gidere ekle
        if ($stockExists) {
            $updateAmount = $stockExists->update(["amount" => $stockExists->amount + $request->amount]);

            $createExpense = ExpenseStatement::create([
                "price" => $price,
                "detail" => $product->name . " ürününden " . $request->amount . " adet eklendi.",
                "table_name" => "stocks",
                "table_id" => $stockExists->id,
                "company_id" => $request->company_id,
                "expense_date" => Carbon::now()
            ]);

            if (!$updateAmount) {
                return response()->json(["message" => "Stok miktarı güncellenirken hata oluştu"], 404);
            }

            return response()->json(["message" => "Stok miktarı başarıyla güncellendi"], 200);
        }

        // Eğer stokta yoksa, stoğa yeni ürün ekle ve giderini ekle
        $createStock = Stock::create($request->validated());

        if (!$createStock) {
            return response()->json(["message" => "Stok oluştururken hata oluştu"], 404);
        }

        $createExpense = ExpenseStatement::create([
            "price" => $price,
            "detail" => $product->name . " ürününden " . $request->amount . " adet eklendi.",
            "table_name" => "stocks",
            "table_id" => $createStock->id,
            "company_id" => $request->company_id,
            "expense_date" => Carbon::now()
        ]);

        if (!$createExpense) {
            return response()->json(["message" => "Gider oluşturulurken hata oluştu"], 404);
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
