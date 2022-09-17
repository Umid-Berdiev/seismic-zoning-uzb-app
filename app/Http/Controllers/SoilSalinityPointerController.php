<?php

namespace App\Http\Controllers;

use App\Imports\SoilSalinityPointerImport;
use App\Models\SoilDataLog;
use App\Models\SoilSalinityPointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SoilSalinityPointerController extends Controller
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
     * @param  \App\Models\SoilSalinityPointer  $soilSalinityPointer
     * @return \Illuminate\Http\Response
     */
    public function show(SoilSalinityPointer $soilSalinityPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoilSalinityPointer  $soilSalinityPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(SoilSalinityPointer $soilSalinityPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoilSalinityPointer  $soilSalinityPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoilSalinityPointer $soilSalinityPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoilSalinityPointer  $soilSalinityPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoilSalinityPointer $soilSalinityPointer)
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

        Excel::import(new SoilSalinityPointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'SoilSalinityPointer',
            'comment' => 'SoilSalinityPointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }
}
