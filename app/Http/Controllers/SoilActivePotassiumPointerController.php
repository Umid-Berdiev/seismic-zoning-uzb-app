<?php

namespace App\Http\Controllers;

use App\Imports\SoilActivePotassiumPointerImport;
use App\Models\SoilActivePotassiumPointer;
use App\Models\SoilDataLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SoilActivePotassiumPointerController extends Controller
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
     * @param  \App\Models\SoilActivePotassiumPointer  $soilActivePotassiumPointer
     * @return \Illuminate\Http\Response
     */
    public function show(SoilActivePotassiumPointer $soilActivePotassiumPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoilActivePotassiumPointer  $soilActivePotassiumPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(SoilActivePotassiumPointer $soilActivePotassiumPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoilActivePotassiumPointer  $soilActivePotassiumPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoilActivePotassiumPointer $soilActivePotassiumPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoilActivePotassiumPointer  $soilActivePotassiumPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoilActivePotassiumPointer $soilActivePotassiumPointer)
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

        Excel::import(new SoilActivePotassiumPointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'SoilActivePotassiumPointer',
            'comment' => 'Soil active potassium pointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }
}
