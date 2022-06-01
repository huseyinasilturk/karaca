<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectivePostRequest;
use App\Http\Requests\ObjectiveRequest;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Nesneler"], ['name' => "Nesneler"]
        ];

        $objectivesTypes = [
            'quality' => [
                'name' => 'Kalite',
                'inputs' => [
                    'text1' => 'Kalite Adı',
                ],
            ],
            'companyType' => [
                'name' => 'Firma Tipi',
                'inputs' => [
                    'text1' => 'Tip',
                ],
            ],
            'productType' => [
                'name' => 'Ürün Tipi',
                'inputs' => [
                    'text1' => 'Tip',
                ],
            ],
            'unitType' => [
                'name' => 'Birim Tipi',
                'inputs' => [
                    'text1' => 'Tip',
                ],
            ],
            'customerType' => [
                'name' => 'Müşteri Tipi',
                'inputs' => [
                    'text1' => 'Tip',
                ],
            ],
            'expenseType' => [
                'name' => 'Gider Tipi',
                'inputs' => [
                    'text1' => 'Tip',
                ],
            ],
        ];

        $objectives = Objective::all()->groupBy("name");

        return view('live.objective.index', compact('objectives', 'objectivesTypes', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObjectiveRequest $request)
    {
        /*
        $objectiveTranslation = Objective::create([
            'name' => $request->name,
            'number1' => !empty($request->number1) ? $request->number1 : null,
            'number2' => !empty($request->number2) ? $request->number2 : null,
            'number3' => !empty($request->number3) ? $request->number3 : null,
            'text1' => !empty($request->text1) ? $request->text1 : null,
            'text2' => !empty($request->text2) ? $request->text2 : null,
            'text3' => !empty($request->text3) ? $request->text3 : null,
        ]);
        */

        // Validation yaptığımız için tüm null kontrolleri yapılmış oluyor :)
        $objectiveTranslation = Objective::create($request->validated());

        if ($objectiveTranslation) {
            return response()->json([
                'status' => 201,
                'message' => __('Nesne Başarıyla Eklendi!'),
                'data' => $request->validated(),
                'id' => $objectiveTranslation->id
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => __('Nesne Eklenirken Hata Oluştu!'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function show(Objective $objective)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ObjectiveRequest $request)
    {
        $data = $request->validated();

        $update = Objective::find($request->id)->update($data);

        if ($update) {
            return response()->json([
                'status' => 200,
                'message' => __('Nesne Başarıyla Güncellendi!'),
                'data' => $request->validated(),
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => __('Nesne Güncellenirken Hata Oluştu!'),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $delete = Objective::findOrFail($request->id)->delete();

        if ($delete) {
            return response()->json([
                'status' => 200,
                'message' => __('Nesne Başarıyla Silindi!'),
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => __('Nesne Silinirken Hata Oluştu!'),
            ]);
        }
    }
}
