<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Company;
use App\Models\FileData;
use App\Models\ListPrice;
use App\Models\Objective;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Ürün"], ['name' => "Listeleme"]
        ];
        $Product = Product::with('productFileData', 'productTypeGet', 'productCompanyGet')->get();
        $Company = Company::all();
        $productTypes = Objective::where("name", "productType")->get();
        return view('live.product.list', compact('Product', 'Company', "breadcrumbs", "productTypes"));
    }

    public function products()
    {
        $Product = Product::with('productFileData', 'productTypeGet', 'productCompanyGet')->get();
        return response()->json($Product, 200);
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Ürün"], ['name' => "Ekle"]
        ];
        $ProductObjectives = Objective::whereName("productType")->get();
        $Company = Company::all();
        return view('live.product.add', compact('ProductObjectives', 'Company', "breadcrumbs"));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'list_price' => $request->list_price,
            'type_id' => $request->type_id
        ]);

        if ($product) {
            $data = [];
            if ($request->hasFile("files")) {
                foreach ($request->file("files") as $key => $file) {
                    $fileName = time() . "_netadim_" . $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    if (in_array(Str::lower($extension), ["jpg", "png", "jpeg", "mpeg", "svg"])) {
                        $file->move(public_path('images/product'), $fileName);
                        array_push($data, ["table_id" => $product->id, "table_name" => "products", "file_name" => $fileName, "type" => "images", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')]);
                    }
                }
                $insertImage = FileData::insert($data);
            }

            $listPrices = $request->listPrice;
            if (!empty($listPrices)) {
                foreach ($listPrices as $companyId => $price) {
                    ListPrice::updateOrCreate(
                        ['company_id' => $companyId, 'product_id' => $product->id],
                        ['list_price' => $price]
                    );
                }
            }

            return redirect()->route('product.edit', $product->id);
        } else {
            return response()->json(['hata' => 'Registration Failed :/'], 405);
        }
    }

    public function edit($id)
    {
        $Product = Product::whereId($id)->with('productFileData', 'productCompanyGet')->first();
        $Product->productCompanyGet = $Product->productCompanyGet->keyBy('company_id');
        $ProductTypeObjectives = Objective::whereName("productType")->get();
        $Company = Company::all();
        return view('live.product.edit', compact('Product', 'ProductTypeObjectives', 'Company'));
    }

    public function update(Request $request)
    {
        if (!empty($request->id)) {
            $product = Product::find($request->id);
            $product->name = $request->name;
            // $product->list_price = $request->list_price;
            $product->type_id = $request->type_id;
            $product->save();
            if ($product) {
                $data = [];
                if ($request->hasFile("files")) {
                    foreach ($request->file("files") as $key => $file) {
                        $fileName = time() . "_netadim_" . $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        if (in_array(Str::lower($extension), ["jpg", "png", "jpeg", "mpeg", "svg"])) {
                            $request->file("files")[$key]->move(public_path('images/product'), $fileName);
                            array_push($data, ["table_id" => $product->id, "table_name" => "products", "file_name" => $fileName, "type" => "images", "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')]);
                        }
                    }
                    FileData::insert($data);
                }

                $priceArray = [];
                $listPrices = $request->listPrice;
                foreach ($listPrices as $companyId => $price) {
                    // array_push($priceArray, ["company_id" => $companyId, "product_id" => $product->id, "list_price" => $price]);
                    ListPrice::updateOrCreate(
                        ['company_id' => $companyId, 'product_id' => $product->id],
                        ['list_price' => $price]
                    );
                }
                // ListPrice::upsert($priceArray, ['list_price'], ['company_id', 'product_id']);
                return redirect()->route('product.edit', $request->id);
            } else {
                return response()->json(['hata' => 'Update Failed :/'], 405);
            }
        } else {
            return response()->json(['hata' => 'Update Failed :/'], 400);
        }
    }

    public function destroy($id)
    {
        if (!empty($id)) {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                return response()->json(['message' => 'Remove Successful :)', 'status' => 202]);
            } else {
                return response()->json(['hata' => 'Remove Failed :/', 'status' => 405]);
            }
        } else {
            return response()->json(['hata' => 'Remove Failed :/', 'status' => 400]);
        }
    }

    public function imageDestroy(Request $request)
    {
        $FileData = FileData::find($request->id);
        $FileLocation = 'images/product/' . $FileData->file_name;
        $FileData = $FileData->delete();
        File::deleteDirectory(public_path($FileLocation));
        return response()->json(['message' => 'Remove Successful :)', 'status' => 202], 202);
    }

    public function filter(Request $request)
    {
        $products = Product::query();

        if ($request->filled("product")) {
            $products = $products->where("name", "LIKE", '%' . $request->product . '%');
        }

        if ($request->filled("product_type_id")) {
            $products = $products->whereRelation("productTypeGet", "id", "=", $request->product_type_id);
        }

        $products = $products->get()->load('productFileData', 'productTypeGet', 'productCompanyGet');

        return response()->json($products, 200);
    }
}
