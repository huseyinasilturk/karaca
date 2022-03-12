<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view("live.company.index");
    }

    public function companies()
    {
        $companies = Company::all();
        return response()->json($companies, 200);
    }

    public function create()
    {
        return view("live.company.add");
    }

    public function store(Request $request)
    {

        if (!$request->filled("name")) {
            return response()->json(["message" => "Firma ismi doldurmak zorundasınız"], 404);
        }

        $createCompany = Company::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "address" => $request->address,
            "note" => $request->note,
        ]);

        if (!$createCompany) {
            return response()->json(["message" => "Firma oluşturulurken hata oluştu"], 404);
        }

        return response()->json(["message" => "Firma başarıyla oluşturuldu"], 201);
    }

    public function delete($id)
    {
        $deleteCompany = Company::find($id)->delete();

        if (!$deleteCompany) {
            return response()->json(["message" => "Firma silinirken hata oluştu"], 404);
        }

        return response()->json(["message" => "Firma başarıyla silindi"], 200);
    }
}
