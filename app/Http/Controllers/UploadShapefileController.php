<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\Segment;
use App\Models\ShapeImportLog;
use App\Models\Zone;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\MultiLineString;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;
use MStaack\LaravelPostgis\Geometries\MultiPolygon;
use Shapefile\Geometry\Polygon as GeometryPolygon;
use Shapefile\Shapefile;
use Shapefile\ShapefileAutoloader;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

// ShapefileAutoloader::register();

class UploadShapefileController extends Controller
{
    public function zonesImportShapefile(Request $request)
    {
        $request->validate([
            'zip' => 'required|file:zip'
        ]);

        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);

                while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    $soato = $Geometry->getDataArray()['SOATO'];
                    $level = $Geometry->getDataArray()['ZONE_VALUE'];

                    $zone = Zone::updateOrCreate(
                        [
                            'soato' => $soato,
                            'level' => $level
                        ],
                        [
                            'geom' => $Geometry->getWKT()
                        ]
                    );

                    foreach (explode(',', $soato) as $key => $value) {
                        DB::table('area_layer')->insert([
                            'area_soato' => $value,
                            'layer_id' => $zone->id,
                            'layer_type' => 'zone'
                        ]);
                    }

                    ShapeImportLog::create([
                        'type' => 'Zona',
                        'comment' => "$level daraja va $soato soato kod bn zona sheypfayli yuklandi!"
                    ]);
                }


                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (Error $e) {
            throw ValidationException::withMessages([
                'zip' => $e->getMessage(),
            ]);
        }
    }

    public function ballsImportShapefile(Request $request)
    {
        $request->validate([
            'zip' => 'required|file:zip'
        ]);

        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);

                while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // dd($Geometry->getDataArray()['BALL_VALUE']);
                    $soato = $Geometry->getDataArray()['SOATO'];
                    $level = $Geometry->getDataArray()['BALL_VALUE'];

                    $ball = Ball::updateOrCreate(
                        [
                            'soato' => $soato,
                            'level' => $level
                        ],
                        [
                            'geom' => $Geometry->getWKT()
                        ]
                    );

                    foreach (explode(',', $soato) as $key => $value) {
                        DB::table('area_layer')->insert([
                            'area_soato' => $value,
                            'layer_id' => $ball->id,
                            'layer_type' => 'ball'
                        ]);
                    }

                    ShapeImportLog::create([
                        'type' => 'Ball',
                        'comment' => "$level daraja va $soato soato kod bn ball sheypfayli yuklandi!"
                    ]);
                }

                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (Error $e) {
            throw ValidationException::withMessages([
                'zip' => $e->getMessage(),
            ]);
        }
    }

    public function bordersImportShapefile(Request $request)
    {
        $request->validate([
            'zip' => 'required|file:zip'
        ]);

        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);
                $linestrings = [];

                while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // dd($Shapefile->getShapeType(Shapefile::FORMAT_STR));
                    // dd($Geometry->getArray()['points']);
                    $soato = $Geometry->getDataArray()['SOATO'];
                    $points = [];
                    foreach ($Geometry->getArray()['points'] as $key => $value) {
                        $points[] = new Point($value['x'], $value['y']);
                    }
                    $linestrings[] = new LineString($points);
                }

                $border = Border::updateOrCreate(
                    [
                        'soato' => $soato,
                    ],
                    [
                        'geom' => new MultiLineString($linestrings)
                    ]
                );

                foreach (explode(',', $soato) as $key => $value) {
                    DB::table('area_layer')->insert([
                        'area_soato' => $value,
                        'layer_id' => $border->id,
                        'layer_type' => 'border'
                    ]);
                }

                ShapeImportLog::create([
                    'type' => 'Chegara',
                    'comment' => "$soato soato kod bn chegara sheypfayli yuklandi!"
                ]);

                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (Error $e) {
            throw ValidationException::withMessages([
                'zip' => $e->getMessage(),
            ]);
        }
    }

    public function segmentsImportShapefile(Request $request)
    {
        $request->validate([
            'zip' => 'required|file:zip'
        ]);

        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);

                while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // dd($Geometry->getDataArray()['BALL_VALUE']);
                    $soato = $Geometry->getDataArray()['SOATO'];
                    $name = $Geometry->getDataArray()['NAME'];

                    $segment = Segment::updateOrCreate(
                        [
                            'soato' => $soato,
                            'name' => $name,
                        ],
                        [
                            'geom' => $Geometry->getWKT()
                        ]
                    );

                    foreach (explode(',', $soato) as $key => $value) {
                        DB::table('area_layer')->insert([
                            'area_soato' => $value,
                            'layer_id' => $segment->id,
                            'layer_type' => 'segment'
                        ]);
                    }

                    ShapeImportLog::create([
                        'type' => 'DSR',
                        'comment' => "$soato soato kod bn DSR sheypfayli yuklandi!"
                    ]);
                }

                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (Error $e) {
            // Print detailed error information
            // echo "Error Type: " . $e->getErrorType()
            //     . "\nMessage: " . $e->getMessage()
            //     . "\nDetails: " . $e->getDetails();

            throw ValidationException::withMessages([
                'zip' => $e->getMessage(),
            ]);
        }
    }
}
