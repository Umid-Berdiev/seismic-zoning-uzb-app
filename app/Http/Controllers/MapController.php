<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\District;
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

        $balls = Ball::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos)
                ->orWhereIn('region_soato', $soatos);
        })
            ->get();

        $zones = Zone::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos)
                ->orWhereIn('region_soato', $soatos);
        })
            ->get();

        $borders = Border::all();

        return response()->json([
            'balls' => $balls,
            'zones' => $zones,
            'borders' => $borders
        ]);
    }

    public function searchLayers(Request $request)
    {
        # code...
    }

    public function fetchLayersByAccuracy(Request $request)
    {
        $balls = Ball::where([
            ['accuracy', $request->accuracy],
            ['soato', 17]
        ])->get();

        return response()->json($balls);
    }
}
