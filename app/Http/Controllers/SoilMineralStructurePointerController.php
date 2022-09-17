<?php

namespace App\Http\Controllers;

use App\Imports\SoilMineralStructurePointerImport;
use App\Models\SoilDataLog;
use App\Models\SoilMineralStructurePointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SoilMineralStructurePointerController extends Controller
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
     * @param  \App\Models\SoilMineralStructurePointer  $soilMineralStructurePointer
     * @return \Illuminate\Http\Response
     */
    public function show(SoilMineralStructurePointer $soilMineralStructurePointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoilMineralStructurePointer  $soilMineralStructurePointer
     * @return \Illuminate\Http\Response
     */
    public function edit(SoilMineralStructurePointer $soilMineralStructurePointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoilMineralStructurePointer  $soilMineralStructurePointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoilMineralStructurePointer $soilMineralStructurePointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoilMineralStructurePointer  $soilMineralStructurePointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoilMineralStructurePointer $soilMineralStructurePointer)
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

        Excel::import(new SoilMineralStructurePointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'SoilMineralStructurePointer',
            'comment' => 'Soil mineral structure pointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }
}
