<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBallRequest;
use App\Http\Requests\UpdateBallRequest;
use App\Models\Ball;

class BallController extends Controller
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
     * @param  \App\Http\Requests\StoreBallRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBallRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ball  $ball
     * @return \Illuminate\Http\Response
     */
    public function show(Ball $ball)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ball  $ball
     * @return \Illuminate\Http\Response
     */
    public function edit(Ball $ball)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBallRequest  $request
     * @param  \App\Models\Ball  $ball
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBallRequest $request, Ball $ball)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ball  $ball
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ball $ball)
    {
        //
    }
}
