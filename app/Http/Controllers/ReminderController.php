<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Models\Reminder;
use Symfony\Component\HttpFoundation\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('live.reminder.list');
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
     * @param  \App\Http\Requests\StoreReminderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only("title", "detail", "date", "status");
        $reminder = Reminder::create($data);
        if ($reminder) {
            return response()->json([
                'status' => 201,
                'message' => __('Hatırlatıcı başarıyla eklendi.'),
                'id' => $reminder->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReminderRequest  $request
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!empty($request->id)) {
            $reminder = Reminder::find($request->id);
            if (!$reminder) {
                return response()->json(["message" => "Hatırlatıcı bulunamadı"], 404);
            }
            $data = $request->only("title", "detail", "date", "status");
            $update = $reminder->update($data);
            if (!$update) {
                return response()->json(["message" => "Hatırlatıcı güncellenirken hata oluştu"], 404);
            }
            return response()->json([
                'status' => 201,
                'message' => 'Hatırlatıcı başarıyla güncellendi.',
                'id' => $reminder->id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!empty($request->id)) {
            $reminder = Reminder::find($request->id);
            if ($reminder) {
                $reminder->delete();
                return response()->json(['message' => 'Silme başarılı :)', 'status' => 201]);
            } else {
                return response()->json(['hata' => 'Silme işleminde bir hata oluştu :/', 'status' => 405]);
            }
        } else {
            return response()->json(['hata' => 'Silme işleminde bir hata oluştu :/', 'status' => 400]);
        }
    }

    function events()
    {
        $Reminder = Reminder::all();
        return response()->json(['message' => 'Successful :)', 'events' => $Reminder, 'status' => 201]);
    }
}
