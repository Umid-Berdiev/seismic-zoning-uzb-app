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
        // $balls = Ball::all();
        // $borders = Border::all();
        // $zones = Zone::all();

        // $gropedBalls = $balls->groupBy('level');

        return Inertia::render('Admin/Map', [
            // 'balls' => $gropedBalls,
            // 'borders' => $borders,
            // 'zones' => $zones
        ]);
    }

    public function fetchLayersBySelectedArea(Request $request)
    {
        $arr = $request->soatos ? array_map(fn ($item) => (int)$item, $request->soatos) : [];
        $soatos = count($arr) ? $arr : [
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
        // dd($soatos);

        $balls = Ball::all();
        $zones = Zone::all();
        $borders = Border::all();
        $filtered_balls = [];
        $filtered_zones = [];
        $filtered_borders = [];

        foreach ($soatos as $key => $soato) {
            $temp_balls = $balls->where(function ($query) use ($soato) {
                return str_starts_with($query->soato, $soato);
            })->groupBy('level');

            if (count($temp_balls)) {
                $filtered_balls[] = $temp_balls;
            }

            $temp_zones = $zones->where(function ($query) use ($soato) {
                return str_starts_with($query->soato, $soato);
            });

            if (count($temp_zones)) {
                $filtered_zones[] = $temp_zones;
            }

            $temp_borders = $borders->where(function ($query) use ($soato) {
                return str_starts_with($query->soato, $soato);
            });

            if (count($temp_borders)) {
                $filtered_borders[] = $temp_borders;
            }
        }

        return response()->json([
            'balls' => $filtered_balls,
            'zones' => $filtered_zones,
            'borders' => $filtered_borders
        ]);
    }
}
