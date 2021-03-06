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
        if (!auth()->user()->can("dayoff.read")) {
            return back();
        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "İzinler"], ['name' => "Listele"]
        ];
        $personals = User::with("information")->get();

        return view("live.dayoff.index", compact("breadcrumbs", "personals"));
    }

    public function create()
    {

        if (!auth()->user()->can("dayoff.add")) {
            return back();
        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "İzinler"], ['name' => "Ekle"]
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

    public function edit($id)
    {

        if (!auth()->user()->can("dayoff.update")) {
            return back();
        }

        $dayOff = DayOff::find($id);

        $personals = User::with("information")->get();

        return view("live.dayoff.edit", compact("personals", "dayOff"));
    }

    public function update(DayOffRequest $request, $id)
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

        $updateDayOff = DayOff::find($id)->update($data);

        if (!$updateDayOff) {
            return response()->json(["errors" => ["day_off" => "İzin oluşturulurken hata oluştu"]], 404);
        }

        return response()->json(["message" => "İzin başarıyla güncellendi"], 201);
    }

    public function delete($id)
    {
        $removeDayOff = DayOff::find($id)->delete();

        if (!$removeDayOff) {
            return response()->json(["errors" => ["dayoff" => "İzin silinirken bir hata oluştu"]], 404);
        }

        return response()->json(["message" => "İzin başarıyla silindi"], 200);
    }

    public function filter(Request $request)
    {
        $dayOffs = DayOff::query();

        if ($request->filled("date")) {
            $month = explode("-", $request->date)[1];
            $dayOffs = $dayOffs->whereMonth("start_date", $month)->orWhereMonth("end_date", $month);
        }

        if ($request->filled("personal_id")) {
            $dayOffs = $dayOffs->whereRelation("person", "id", "=", $request->personal_id);
        }

        $dayOffs = $dayOffs->get()->load("person", "person.information");

        return response()->json($dayOffs, 200);
    }
}
