<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileDataRequest;
use App\Http\Requests\UpdateFileDataRequest;
use App\Models\FileData;

class FileDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreFileDataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileData  $fileData
     * @return \Illuminate\Http\Response
     */
    public function show(FileData $fileData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileData  $fileData
     * @return \Illuminate\Http\Response
     */
    public function edit(FileData $fileData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileDataRequest  $request
     * @param  \App\Models\FileData  $fileData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileDataRequest $request, FileData $fileData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileData  $fileData
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileData $fileData)
    {
        //
    }
}
