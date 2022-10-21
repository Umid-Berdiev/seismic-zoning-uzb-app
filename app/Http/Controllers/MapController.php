<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\Zone;
use GeoJson\Geometry\GeometryCollection;
use GeoJson\Geometry\LineString;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        $balls = Ball::all();
        $borders = Border::latest('id')->get();
        $zones = Zone::all();

        $gropedBalls = $balls->groupBy('level');

        return Inertia::render('Admin/Map', [
            'balls' => $gropedBalls,
            'borders' => $borders,
            'zones' => $zones
        ]);
    }

    public function fetchLayersBySelectedArea(Request $request)
    {
        // dd($request->all());
        $arr = explode(',', $request->soatos);
        // dd($arr);
        $balls = Ball::all();
        $filteredBalls = [];

        foreach ($arr as $key => $value) {
            $data = $balls->where(function ($query) use ($value) {
                return str_starts_with($query->soato, $value);
            });

            if ($data->count()) {
                $filteredBalls[] = $data;
            }
        }

        $filteredBalls = array_unique($filteredBalls, 'soato');
        dd($filteredBalls);
        $borders = Border::whereIn('soato', $arr)->get();
        $zones = Zone::whereIn('soato', $arr)->get();

        // $gropedBalls = $balls->groupBy('level');

        return response()->json([$balls, $borders, $zones]);
    }
}
