<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockLimitRequest;
use App\Models\Company;
use App\Models\Product;
use App\Models\StockLimit;
use Illuminate\Http\Request;

class StockLimitController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can("stockLimit.read")) {
            return back();
        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Listele"]
        ];

        return view("live.stockLimit.index", compact("breadcrumbs"));
    }

    public function add()
    {
        if (!auth()->user()->can("stockLimit.add")) {
            return back();
        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Ekle"]
        ];
        $Company = Company::all();

        $products = Product::with("productStock")->get();

        return view("live.stockLimit.add", compact("breadcrumbs", "products", "Company"));
    }

    public function store(StockLimitRequest $request)
    {
        $stockLimitControl = StockLimit::where("company_id", $request->company_id)->where("product_id", $request->product_id)->first();
        if (!empty($stockLimitControl)) {
            return response()->json(["message" => "Bu ürün seçili firmaya daha önce stok eklemesi yapılmış lütfen oradan devam ediniz. "], 404);
        } else {
            $createLimit = StockLimit::create($request->validated());

            if (!$createLimit) {
                return response()->json(["message" => "Limit oluşturulurken hata oluştu"], 404);
            }

            return response()->json(["message" => "Limit başarıyla oluşturuldu"], 201);
        }
    }

    public function edit($id)
    {
        if (!auth()->user()->can("stockLimit.update")) {
            return back();
        }
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Stok Limiti"], ['name' => "Güncelle"]
        ];

        $stockLimit = StockLimit::find($id);
        $Company = Company::all();
        $products = Product::with("productStock")->get();


        return view("live.stockLimit.edit", compact("products", "breadcrumbs", "Company", "stockLimit"));
    }

    public function update(StockLimitRequest $request, $id)
    {
        $stockLimitControl = StockLimit::whereNotIn('id', [$id])->where("company_id", $request->company_id)->where("product_id", $request->product_id)->first();
        if (!empty($stockLimitControl)) {
            return response()->json(["message" => "Bu ürün seçili firmaya daha önce stok eklemesi yapılmış lütfen oradan devam ediniz. "], 404);
        }
        $updateLimit = StockLimit::find($id)->update($request->validated());

        if (!$updateLimit) {
            return response()->json(["errors" => ["update" => "Limit güncellenirken hata oluştu"]], 404);
        }

        return response()->json(["message" => "Limit başarıyla güncellendi"], 200);
    }

    public function limits()
    {
        $limits = StockLimit::with("product", "company")->get();
        return ($limits);

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

    public function filter(Request $request)
    {
        $stockLimits = StockLimit::query();

        if ($request->filled("product")) {
            $stockLimits = $stockLimits->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->product . '%');
            });
        }

        $stockLimits = $stockLimits->get()->load("product", "company");

        return response()->json($stockLimits, 200);
    }
}
