<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Objective;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Firmalar"], ['name' => "Firma Listele"]
        ];
        return view("live.company.index", compact("breadcrumbs"));
    }

    public function companies()
    {
        $companies = Company::all();
        return response()->json($companies, 200);
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Firmalar"], ['name' => "Firma Ekle"]
        ];
        $companyTypes = Objective::where("name", "=", "companyType")->get();
        return view("live.company.add", compact("companyTypes", "breadcrumbs"));
    }

    public function store(Request $request)
    {
        if (!$request->filled("name")) {
            return response()->json(["message" => "Firma ismi doldurmak zorundasınız"], 404);
        }

        if ($request->company_type === "-1") {
            return response()->json(["message" => "Firma tipi seçmek zorundasınız"], 404);
        }

        $data = $request->only("name", "phone", "address", "note", "company_type");
        $createCompany = Company::create($data);

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

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Firmalar"], ['name' => "Firma Güncelle"]
        ];
        $company = Company::find($id);
        $companyTypes = Objective::where("name", "=", "companyType")->get();
        if ($company == null) {
            return view("live.company.add", compact("companyTypes"));
        }
        return view("live.company.edit", compact("companyTypes", "company", "breadcrumbs"));
    }

    public function update(Request $request)
    {
        if (!$request->filled("name")) {
            return response()->json(["message" => "Firma ismi doldurmak zorundasınız"], 404);
        }

        if ($request->company_type === "-1") {
            return response()->json(["message" => "Firma tipi seçmek zorundasınız"], 404);
        }

        $data = $request->only("id", "name", "phone", "address", "note", "company_type");
        $updateCompany = Company::find($request->id)->update($data);

        if (!$updateCompany) {
            return response()->json(["message" => "Firma güncellenirken hata oluştu"], 404);
        }

        return response()->json(["message" => "Firma başarıyla güncellendi"], 201);
    }
}
