<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use GeoJson\Geometry\GeometryCollection;
use GeoJson\Geometry\LineString;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        $borders = Border::latest('id')->get();
        $balls = Ball::latest('id')->get();
        // dd($balls);
        $border_geometries = [];
        $ball_geometries = [];

        foreach ($borders as $border) {
            $border_geometries[] = $border->line->jsonSerialize();
        }

        // foreach ($balls as $key => $ball) {
        //     // dd($ball->polygon->jsonSerialize());
        //     $ball_geometries[] = $ball->polygon->jsonSerialize();
        // }

        // dd($ball_geometries);
        $borderGeodata =  new GeometryCollection($border_geometries);
        // $ballGeodata =  new GeometryCollection($ball_geometries);

        // dd($ballGeodata->getGeometries());
        return Inertia::render('Admin/Map', [
            'borders' => $borderGeodata->getGeometries()[0]->getCoordinates(),
            'balls' => $balls
        ]);
    }
}
