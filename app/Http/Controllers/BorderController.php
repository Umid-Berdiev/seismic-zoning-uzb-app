<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBordersRequest;
use App\Http\Requests\UpdateBordersRequest;
use App\Models\Borders;

class BorderController extends Controller
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
     * @param  \App\Http\Requests\StoreBordersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBordersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borders  $borders
     * @return \Illuminate\Http\Response
     */
    public function show(Borders $borders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borders  $borders
     * @return \Illuminate\Http\Response
     */
    public function edit(Borders $borders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBordersRequest  $request
     * @param  \App\Models\Borders  $borders
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBordersRequest $request, Borders $borders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borders  $borders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borders $borders)
    {
        //
    }
}
