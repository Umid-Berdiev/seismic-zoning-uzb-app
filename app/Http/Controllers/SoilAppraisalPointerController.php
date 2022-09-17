<?php

namespace App\Http\Controllers;

use App\Imports\SoilAppraisalPointerImport;
use App\Models\SoilAppraisalPointer;
use App\Models\SoilDataLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SoilAppraisalPointerController extends Controller
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
     * @param  \App\Models\SoilAppraisalPointer  $soilAppraisalPointer
     * @return \Illuminate\Http\Response
     */
    public function show(SoilAppraisalPointer $soilAppraisalPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoilAppraisalPointer  $soilAppraisalPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(SoilAppraisalPointer $soilAppraisalPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoilAppraisalPointer  $soilAppraisalPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoilAppraisalPointer $soilAppraisalPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoilAppraisalPointer  $soilAppraisalPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoilAppraisalPointer $soilAppraisalPointer)
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

        Excel::import(new SoilAppraisalPointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'SoilAppraisalPointer',
            'comment' => 'SoilAppraisalPointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }
}
