<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Company;
use App\Models\FileData;
use App\Models\ListPrice;
use App\Models\Objective;
use App\Models\Product;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Product=Product::with('productFileData','productTypeGet','productCompanyGet')->get();
        // dd($Product);
        $Company=Company::all();
        return view('live.product.list', compact('Product','Company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ProductObjectives=Objective::whereName("productType")->get();
        $Company=Company::all();
        return view('live.product.add', compact('ProductObjectives','Company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'list_price' => $request->list_price,
            'type_id' => $request->type_id
        ]);

        if($product){
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
            $listPrices=$request->listPrice;
            foreach ($listPrices as $companyId => $price) {
                ListPrice::updateOrCreate(
                    ['company_id' => $companyId, 'product_id' => $product->id],
                    ['list_price' => $price]
                );
            }
            return redirect()->route('product.edit',$product->id);
        } else {
            return response()->json(['hata'=>'Registration Failed :/'],405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Product=Product::whereId($id)->with('productFileData','productCompanyGet')->first();
        $Product->productCompanyGet=$Product->productCompanyGet->keyBy('company_id');
        $ProductTypeObjectives=Objective::whereName("productType")->get();
        $Company=Company::all();
        return view('live.product.edit', compact('Product','ProductTypeObjectives','Company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!empty($request->id)){
            $product = Product::find($request->id);
            $product->name = $request->name;
            // $product->list_price = $request->list_price;
            $product->type_id = $request->type_id;
            $product->save();
            if($product){
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
                $listPrices=$request->listPrice;
                foreach ($listPrices as $companyId => $price) {
                    // array_push($priceArray, ["company_id" => $companyId, "product_id" => $product->id, "list_price" => $price]);
                    ListPrice::updateOrCreate(
                        ['company_id' => $companyId, 'product_id' => $product->id],
                        ['list_price' => $price]
                    );
                }
                // ListPrice::upsert($priceArray, ['list_price'], ['company_id', 'product_id']);
                return redirect()->route('product.edit',$request->id);
            } else {
                return response()->json(['hata'=>'Update Failed :/'],405);
            }
        }else{
            return response()->json(['hata'=>'Update Failed :/'],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!empty($id)){
            $product = Product::find($id);
            if($product){
                $product->delete();
                return response()->json(['message'=>'Remove Successful :)','status'=>202]);
            }else{
                return response()->json(['hata'=>'Remove Failed :/','status'=>405]);
            }
        }else{
            return response()->json(['hata'=>'Remove Failed :/','status'=>400]);
        }
    }

    public function imageDestroy(Request $request)
    {
        $FileData = FileData::find($request->id);
        $FileLocation='images/product/'.$FileData->file_name;
        $FileData=$FileData->delete();
        File::deleteDirectory(public_path($FileLocation));
        return response()->json(['message'=>'Remove Successful :)','status'=>202],202);
    }
}
