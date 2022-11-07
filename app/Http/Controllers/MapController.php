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
        $soatos = $request->soatos || [
            1735,
            1733,
            1712,
            1706,
            1718,
            1722,
            1708,
            1724,
            1703,
            1714,
            1730,
            1727,
            1710,
        ];
        $arr = explode(',', $request->soatos);
        // dd($arr);
        $balls = Ball::all();
        $zones = Zone::all();
        $borders = Border::all();
        $filteredBalls = [];
        $filteredZones = [];
        $filteredBorders = [];

        foreach ($arr as $key => $value) {
            $balls_data = $balls->where(function ($query) use ($value) {
                return str_starts_with($query->soato, $value);
            });

            $zones_data = $zones->where(function ($query) use ($value) {
                return str_starts_with($query->soato, $value);
            });

            $borders_data = $borders->where(function ($query) use ($value) {
                return str_starts_with($query->soato, $value);
            });

            if ($balls_data->count()) {
                $filteredBalls[] = $balls_data;
            }

            if ($zones_data->count()) {
                $filteredZones[] = $zones_data;
            }

            if ($borders_data->count()) {
                $filteredBorders[] = $borders_data;
            }
        }

        // $filteredBalls = array_unique(array_column($filteredBalls, 'soato'));
        // dd($filteredBalls);
        // $borders = Border::whereIn('soato', $arr)->get();
        // $zones = Zone::whereIn('soato', $arr)->get();

        // $gropedBalls = $balls->groupBy('level');

        return response()->json([
            'balls' => $filteredBalls,
            'zones' => $filteredZones,
            'borders' => $filteredZones
        ]);
    }
}
