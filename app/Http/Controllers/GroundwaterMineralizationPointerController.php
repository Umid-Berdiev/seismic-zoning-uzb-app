<?php

namespace App\Http\Controllers;

use App\Imports\GroundwaterMineralizationPointerImport;
use App\Models\GroundwaterDataLog;
use App\Models\GroundwaterMineralizationPointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class GroundwaterMineralizationPointerController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroundwaterMineralizationPointer  $groundwaterMineralizationPointer
     * @return \Illuminate\Http\Response
     */
    public function show(GroundwaterMineralizationPointer $groundwaterMineralizationPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroundwaterMineralizationPointer  $groundwaterMineralizationPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(GroundwaterMineralizationPointer $groundwaterMineralizationPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroundwaterMineralizationPointer  $groundwaterMineralizationPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroundwaterMineralizationPointer $groundwaterMineralizationPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroundwaterMineralizationPointer  $groundwaterMineralizationPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroundwaterMineralizationPointer $groundwaterMineralizationPointer)
    {
        //
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => ['required']
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'import_file' => __('file_not_found'),
            ]);
        }

        Excel::import(new GroundwaterMineralizationPointerImport, $request->file('import_file'));

        GroundwaterDataLog::create([
            'type' => 'GroundwaterMineralizationPointer',
            'comment' => 'Groundwater mineralization pointer data imported from excel file'
        ]);

        return Redirect::route('admin.groundwater_data');
    }
}
