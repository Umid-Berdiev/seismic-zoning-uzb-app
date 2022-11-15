<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDsrSectionRequest;
use App\Http\Requests\UpdateDsrSectionRequest;
use App\Models\DsrSection;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DsrSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = DsrSection::with('regions')->get();
        $used_region_ids = DsrSection::pluck('soatos');
        // dd($used_region_ids);
        $arr = [];
        foreach ($used_region_ids as $key => $value) {
            foreach (explode(',', $value) as $key2 => $value2) {
                $arr[] = $value2;
            }
        }
        $regions = Region::get(['id', 'name_uz', 'soato']);
        // $regions = Region::whereNotIn('id', $arr)->get(['id', 'name_uz', 'soato']);
        // $filteredRegions = array_filter($regions, fn ($region) => !in_array($region['id'], $arr));
        // dd($arr);
        // dd($regions);

        return Inertia::render('Admin/Directory/DsrSection', [
            'list' => $list,
            'regions' => $regions,
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
     * @param  \App\Http\Requests\StoreDsrSectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDsrSectionRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'soatos' => 'string',
            'details' => 'string|nullable|max:255'
        ]);

        $dsrSection = DsrSection::create($validated);
        $dsrSection->regions()->attach(explode(',', $validated['soatos']));
        return redirect(route('dsr-sections.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DsrSection  $dsrSection
     * @return \Illuminate\Http\Response
     */
    public function show(DsrSection $dsrSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DsrSection  $dsrSection
     * @return \Illuminate\Http\Response
     */
    public function edit(DsrSection $dsrSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDsrSectionRequest  $request
     * @param  \App\Models\DsrSection  $dsrSection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDsrSectionRequest $request, DsrSection $dsrSection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'soatos' => 'string',
            'details' => 'string|nullable|max:255'
        ]);

        $dsrSection->update($validated);
        $dsrSection->regions()->detach();
        $dsrSection->regions()->attach(explode(',', $validated['soatos']));
        return redirect(route('dsr-sections.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DsrSection  $dsrSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(DsrSection $dsrSection)
    {
        $this->authorize('delete', $dsrSection);

        $dsrSection->delete();

        return redirect(route('dsr-sections.index'));
    }
}
