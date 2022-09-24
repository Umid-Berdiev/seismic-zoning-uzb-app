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
}
