<?php

namespace App\Http\Controllers;

use App\Exports\DistrictExport;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\District;
use App\Models\Region;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region)
    {
        $districts = $region->districts;

        return Inertia::render('Admin/Directory/Districts', [
            'districts' => $districts
        ]);
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
     * @param  \App\Http\Requests\StoreDistrictRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDistrictRequest  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update([
            'name_uz' => $request->name_uz,
            'name_ru' => $request->name_ru,
            'admincenter_uz' => $request->admincenter_uz,
            'admincenter_ru' => $request->admincenter_ru
        ]);

        return redirect(route('districts.index', $district->region->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }

    public function export(Region $region)
    {
        $data = $region->districts()->get(['soato', 'name_uz', 'name_ru', 'admincenter_uz', 'admincenter_ru']);
        // dd($data);

        return Excel::download(new DistrictExport($data), $region->soato . '_districts.xlsx');
    }
}
