<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\ShapeImportLog;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;
use Shapefile\Geometry\Polygon as GeometryPolygon;
use Shapefile\Shapefile;
use Shapefile\ShapefileAutoloader;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

// ShapefileAutoloader::register();

class UploadShapefileController extends Controller
{
    public function ballsImportShapefile(Request $request)
    {
        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);
                $ball = new Ball();
                $ball->soato = 1703;
                $ball->level = 9;
                $ball->polygon = $Shapefile->fetchRecord()->getWKT();
                $ball->save();

                ShapeImportLog::create([
                    'type' => 'Ball',
                    'comment' => 'Ball data with 9 level imported from shape file'
                ]);
            }

            return redirect(route('statics'));
        } catch (ShapefileException $e) {
            throw ValidationException::withMessages([
                'zip' => __($e->getMessage() . "\nDetails: " . $e->getDetails()),
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

                while ($Geometry = $Shapefile->fetchRecord()) {
                    $linestring = [];

                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    $points = $Geometry->getArray()['points'];

                    foreach ($points as $key => $value) {
                        $linestring[] = new Point($value['x'], $value['y']);
                    }

                    $border = new Border();
                    $border->soato = 1703;
                    $border->line = new LineString($linestring);
                    $border->save();
                }
            }

            ShapeImportLog::create([
                'type' => 'Border',
                'comment' => 'Border data imported from shape file'
            ]);

            return redirect(route('statics'));
            // dd($geojson_data);
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
