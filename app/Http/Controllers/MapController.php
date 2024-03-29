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

    public function grunt()
    {
        return Inertia::render('Admin/Grunt');
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
        $soatos = $request->soatos ?? [];
        $data = [];

        if ($request->layer_group === 'balls')
            $data = Ball::whereHas('districts', function ($query) use ($soatos) {
                $query->whereIn('soato', $soatos);
            })
                ->whereNot('soato', 17)
                ->orderBy('level')
                ->get();

        if ($request->layer_group === 'zones')
            $data = Zone::whereHas('districts', function ($query) use ($soatos) {
                $query->whereIn('soato', $soatos);
            })
                ->whereNot('soato', 17)
                ->orderBy('pga_value')
                ->get();

        if ($request->layer_group === 'vs30') {
            // get data from /public/geojson_data/vs30_namangan.geojson
            $geoData = json_decode(file_get_contents(public_path('geojson_data/vs30_namangan.geojson')));
            $data = $geoData;
        }

        return response()->json($data);
    }

    public function fetchLayersByAccuracy(Request $request)
    {
        $balls = Ball::where([
            ['accuracy', $request->accuracy],
            ['soato', 17]
        ])
            ->orderBy('level')
            ->get();

        return response()->json($balls);
    }

    public function fetchFyyLayers(Request $request)
    {
        // get data from /public/geojson_data/tashkent_region_fyy.geojson
        $geoData = json_decode(file_get_contents(public_path('geojson_data/tashkent_region_fyy.geojson')));

        return response()->json($geoData);
    }

    public function findPointInPolygon(Request $request)
    {
        $osr = ['balls' => [], 'zones' => []];
        $dsr = ['balls' => [], 'zones' => []];
        $smr = ['balls' => [], 'zones' => []];
        $fyy = [];
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
            if (strlen($ball->soato) === 9 || strlen($ball->soato) === 14) {
                $dsr['balls'][] = $ball;
                continue;
            }
            if (strlen($ball->soato) === 6 || strlen($ball->soato) === 7) {
                $smr['balls'][] = $ball;
            }
        }

        $zoneQuery = "SELECT accuracy, id, pga_value, soato FROM zones WHERE ST_Contains(
            geom::geometry,
            'SRID=4326;POINT($lng $lat)'::geometry
        )";

        $zones = DB::select(DB::raw($zoneQuery));

        foreach ($zones as $key => $zone) {
            if ($zone->soato == '17') {
                $osr['zones'][] = $zone;
                continue;
            }
            if (strlen($zone->soato) === 9 || strlen($zone->soato) === 14) {
                $dsr['zones'][] = $zone;
                continue;
            }
            if (strlen($zone->soato) === 6 || strlen($zone->soato) === 7) {
                $smr['zones'][] = $zone;
            }
        }

        // $fyyGeoData = json_decode(file_get_contents(public_path('geojson_data/tashkent_region_fyy.geojson')));

        // foreach ($fyyGeoData->features as $key => $feature) {
        //     if ($feature->geometry->type === 'MultiLineString') {
        //         foreach ($feature->geometry->coordinates as $key => $coordinates) {
        //             $lineString = new LineString($coordinates);
        //             in_array([$lng, $lat], $lineString->getCoordinates()) && $fyy[] = $feature;
        //         }
        //     }
        // }

        return response()->json([
            'osr' => $osr,
            'dsr' => $dsr,
            'smr' => $smr,
            'fyy' => $fyy,
        ]);
    }
}
