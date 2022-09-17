<?php

namespace App\Http\Controllers;

use App\Imports\GumusPointerImport;
use App\Models\GumusPointer;
use App\Models\SoilDataLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class GumusPointerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GumusPointer::latest('id')->take(3)->get();
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
     * @param  \App\Models\GumusPointer  $gumusPointer
     * @return \Illuminate\Http\Response
     */
    public function show(GumusPointer $gumusPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GumusPointer  $gumusPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(GumusPointer $gumusPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GumusPointer  $gumusPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GumusPointer $gumusPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GumusPointer  $gumusPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(GumusPointer $gumusPointer)
    {
        //
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => ['required']
        ]);

        if ($validator->fails()) {
            // return back()->withErrors($validator->errors());
            throw ValidationException::withMessages([
                'import_file' => __('file_not_found'),
            ]);
        }

        Excel::import(new GumusPointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'GumusPointer',
            'comment' => 'GumusPointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }
}
