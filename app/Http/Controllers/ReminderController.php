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
        $reminder = Reminder::create([
            'title' => $request->title,
            'detail' => $request->detail,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        if($reminder){
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
            $reminder->title = $request->title;
            $reminder->detail = $request->detail;
            $reminder->start_date = $request->start_date;
            $reminder->end_date = $request->end_date;
            $reminder->save();
            if($reminder){
                return response()->json([
                    'status' => 201,
                    'message' => __('Hatırlatıcı başarıyla güncellendi.'),
                    'id' => $reminder->id
                ]);
            }
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
                return response()->json(['message' => 'Remove Successful :)', 'status' => 201]);
            } else {
                return response()->json(['hata' => 'Remove Failed :/', 'status' => 405]);
            }
        } else {
            return response()->json(['hata' => 'Remove Failed :/', 'status' => 400]);
        }
    }

    function events(Request $request)
    {
        $Reminder = Reminder::select('id','title','start_date as start','end_date as end','detail')->get();
        return response()->json(['message' => 'Successful :)', 'events'=>$Reminder, 'status' => 201]);
    }
}
