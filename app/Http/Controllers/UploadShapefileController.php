<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\ShapeImportLog;
use App\Models\Zone;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use MStaack\LaravelPostgis\Geometries\LineString;
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
        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);
                $polygons = [];

                while ($Geometry = $Shapefile->fetchRecord()) {
                    $points = [];

                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // dd($Shapefile->getShapeType(Shapefile::FORMAT_STR));
                    // dd($Geometry->getArray());

                    foreach ($Geometry->getArray()['rings'] as $key1 => $value1) {
                        $points = [];
                        foreach ($value1['points'] as $key2 => $value2) {
                            $points[] = new Point($value2['x'], $value2['y']);
                        }
                        $polygons[] = new Polygon([new LineString($points)]);
                    }

                    // dd($points);
                    // $linestring = new LineString($points);

                }

                // dd($polygons);
                $zone = new Zone();
                $zone->soato = 1703;
                $zone->level = 45;
                $zone->geom = new MultiPolygon($polygons);
                $zone->save();

                ShapeImportLog::create([
                    'type' => 'Zone',
                    'comment' => 'Zone data with 45 level imported from shape file'
                ]);

                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (ShapefileException $e) {
            throw ValidationException::withMessages([
                'zip' => __($e->getMessage() . "\nDetails: " . $e->getDetails()),
            ]);
        }
    }

    public function ballsImportShapefile(Request $request)
    {
        $request->validate([
            'zip' => 'required|zip'
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
                    // $linestring = [];
                    $points = [];

                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // dd($Shapefile->getShapeType(Shapefile::FORMAT_STR));
                    // dd($Geometry->getArray());

                    foreach ($Geometry->getArray()['rings'] as $key1 => $value1) {
                        $points = [];
                        foreach ($value1['points'] as $key2 => $value2) {
                            $points[] = new Point($value2['x'], $value2['y']);
                        }
                        // $points[] = new LineString($points);
                    }

                    // dd($points);
                    $linestring = new LineString($points);

                    $ball = new Ball();
                    $ball->soato = 1703;
                    $ball->level = 8;
                    $ball->polygon = new Polygon([$linestring]);
                    $ball->save();

                    ShapeImportLog::create([
                        'type' => 'Ball',
                        'comment' => 'Ball data with 8 level imported from shape file'
                    ]);
                }

                File::cleanDirectory($extracted_file_path);

                return redirect(route('statics'));
            }
        } catch (Error $e) {
            throw ValidationException::withMessages([
                'zip' => __($e->getMessage()),
            ]);
        }
    }

    public function bordersImportShapefile(Request $request)
    {
        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);
                $points = $Shapefile->fetchRecord()->getArray()['points'];
                $linestring = [];

                foreach ($points as $key => $value) {
                    $linestring[] = new Point($value['x'], $value['y']);
                }

                $border = new Border();
                $border->soato = 1703;
                $border->line = new LineString($linestring);
                $border->save();

                ShapeImportLog::create([
                    'type' => 'Border',
                    'comment' => 'Border data imported from shape file'
                ]);

                return redirect(route('statics'));
            }
        } catch (ShapefileException $e) {
            // Print detailed error information
            // echo "Error Type: " . $e->getErrorType()
            //     . "\nMessage: " . $e->getMessage()
            //     . "\nDetails: " . $e->getDetails();

            throw ValidationException::withMessages([
                'zip' => __($e->getMessage() . "\nDetails: " . $e->getDetails()),
            ]);
        }
    }
}
