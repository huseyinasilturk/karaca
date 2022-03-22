<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
use App\Models\DayOff;
use App\Models\User;
use Illuminate\Http\Request;

class DayOffController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "İzin"], ['name' => "İzinler"]
        ];
        return view("live.dayoff.index", compact("breadcrumbs"));
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "İzin"], ['name' => "İzin Ekle"]
        ];

        $personals = User::with("information")->get();

        return view("live.dayoff.add", compact("breadcrumbs", "personals"));
    }

    public function store(DayOffRequest $request)
    {
        $data = $request->validated();

        $calculateDay = round((strtotime($data["end_date"]) - strtotime($data["start_date"])) / (60 * 60 *  24));

        if ($calculateDay < 0) {
            return response()->json(["errors" => ["date" => "İzin bitiş tarihi, başlangıç tarihinden önce olamaz"]], 404);
        }

        $data["day"] = $calculateDay;

        if ($data["personal_id"] == "-1") {
            return response()->json(["errors" => ["personal_id" => "Personel seçmelisiniz"]], 404);
        }

        $createDayOff = DayOff::create($data);

        if (!$createDayOff) {
            return response()->json(["errors" => ["day_off" => "İzin oluşturulurken hata oluştu"]], 404);
        }

        return response()->json(["message" => "İzin başarıyla oluşturuldu"], 201);
    }

    public function dayOffs()
    {
        $dayOffs = DayOff::with("person", "person.information")->get();
        return response()->json($dayOffs, 200);
    }

    public function update(DayOffRequest $request)
    {
    }

    public function edit($id)
    {
        $dayOff = DayOff::find($id);

        $personals = User::with("information")->get();

        return view("live.dayoff.edit", compact("personals", "dayOff"));
    }
}
