<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\District;
use App\Models\Zone;
use GeoJson\Geometry\GeometryCollection;
use GeoJson\Geometry\LineString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function fetchDsrLayers(Request $request)
    {
        $soatos = $request->soatos;
        // dd($soatos);
        $data = [];

        if ($request->layer_group === 'balls') $data = Ball::whereHas('regions', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos);
        })
            // ->whereNot('soato', 17)
            ->get();

        if ($request->layer_group === 'zones') $data = Zone::whereHas('regions', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos);
        })
            // ->whereNot('soato', 17)
            ->get();

        return response()->json($data);
    }

    public function fetchSmrLayers(Request $request)
    {
        $soatos = $request->soatos;
        $data = [];

        if ($request->layer_group === 'balls') $data = Ball::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos);
        })
            ->whereNot('soato', 17)
            ->get();

        if ($request->layer_group === 'zones') $data = Zone::whereHas('districts', function ($query) use ($soatos) {
            $query->whereIn('soato', $soatos);
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

    public function findPointInPolygon(Request $request)
    {
        $osr = ['balls' => [], 'zones' => []];
        $dsr = ['balls' => [], 'zones' => []];
        $smr = ['balls' => [], 'zones' => []];
        $lat = $request->latitude;
        $lng = $request->longitude;

        $ballQuery = "SELECT accuracy, id, level, soato FROM balls WHERE _ST_Contains(
            geom::geometry,
            'SRID=4326;POINT($lng $lat)'::geometry
        )";

        $balls = DB::select(DB::raw($ballQuery));

        foreach ($balls as $key => $ball) {
            if ($ball->soato == '17') {
                $osr['balls'][] = $ball;
                continue;
            }
        }

        $zoneQuery = "SELECT accuracy, id, pga_value, soato FROM zones WHERE ST_Contains(
            geom::geometry,
            'SRID=4326;POINT($lng $lat)'::geometry
        )";

        $zones = DB::select(DB::raw($zoneQuery));

        return response()->json([
            'osr' => $osr,
            'dsr' => $dsr,
            'smr' => $smr
        ]);
    }
}
