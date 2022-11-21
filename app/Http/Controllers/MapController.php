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
        $soatos = $request->soatos ? array_map(fn ($item) => (int)$item, $request->soatos) : [];

        $data = [];

        if ($request->layer_group === 'balls') $data = Ball::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('region_soato', $soatos);
            // ->orWhereIn('soato', $soatos);
        })
            ->whereNot('soato', 17)
            ->get();

        if ($request->layer_group === 'zones') $data = Zone::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('region_soato', $soatos);
            // ->orWhereIn('soato', $soatos);
        })
            ->whereNot('soato', 17)
            ->get();

        return response()->json($data);
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
