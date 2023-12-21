<?php

namespace App\Http\Controllers;

use App\Models\Accelerogram;
use App\Http\Requests\StoreAccelerogramRequest;
use App\Http\Requests\UpdateAccelerogramRequest;
use App\Imports\AccelerogramImport;
use App\Models\AccelerogramFile;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AccelerogramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $regions = Region::all();
        // $accelerogramFiles = Storage::disk('public')->files('accelerograms');
        // $accelerogramFiles = array_map(function ($file) {
        //     return basename($file);
        // }, $accelerogramFiles);

        $accelerogramFiles = AccelerogramFile::with('region')->get();

        return Inertia::render(
            'Admin/Accelerogram',
            [
                'list' => $accelerogramFiles,
                'regions' => $regions
            ]
        );
    }

    public function charts(Request $request)
    {
        $accuracy = $request->accuracy ?? 90;
        $region_soato = $request->region_soato ?? 1703;
        $result = Accelerogram::with('region')
            ->where('accuracy', $accuracy)
            ->where('region_soato', $region_soato)
            ->get();

        $regions = Region::all();

        return Inertia::render(
            'Admin/AccelerogramCharts',
            [
                'list' => $result,
                'regions' => $regions
            ]
        );
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
     * @param  \App\Http\Requests\StoreAccelerogramRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccelerogramRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accelerogram  $accelerogram
     * @return \Illuminate\Http\Response
     */
    public function show(Accelerogram $accelerogram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accelerogram  $accelerogram
     * @return \Illuminate\Http\Response
     */
    public function edit(Accelerogram $accelerogram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccelerogramRequest  $request
     * @param  \App\Models\Accelerogram  $accelerogram
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccelerogramRequest $request, Accelerogram $accelerogram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accelerogram  $accelerogram
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accelerogram $accelerogram)
    {
        //
    }

    /**
     * Import accelerograms from excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            $request->validate(
                [
                    'excel_file' => 'required|mimes:xlsx,xls',
                    'region_soato' => 'required|exists:regions,soato'
                ]
            );

            $excel_file_path = "/storage/app/public/accelerograms/{$request->file('excel_file')->getClientOriginalName()}";
            $excelFile = $request->file('excel_file');
            $excelFile->storeAs('public/accelerograms', $excelFile->getClientOriginalName());

            Excel::import(new AccelerogramImport($request->region_soato), $excelFile);
            AccelerogramFile::updateOrCreate(
                [
                    'region_soato' => $request->region_soato,
                ],
                [
                    'name' => $excelFile->getClientOriginalName(),
                    'path' => $excel_file_path
                ]
            );

            return redirect()->back()->with('success', 'Accelerograms imported successfully.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function removeAccelerogramFile(AccelerogramFile $accelerogramFile)
    {
        // dd($accelerogramFile);
        try {
            Accelerogram::where('region_soato', $accelerogramFile->region_soato)->delete();
            Storage::disk('public')->delete($accelerogramFile->path);
            $accelerogramFile->delete();
            return redirect()->back()->with('success', 'Accelerogram file deleted successfully.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
