<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Border;
use App\Models\District;
use App\Models\Region;
use App\Models\Segment;
use App\Models\ShapeImportLog;
use App\Models\Zone;
use Error;
use GeoJson\Geometry\MultiPolygon as GeometryMultiPolygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\MultiLineString;
use MStaack\LaravelPostgis\Geometries\MultiPolygon as GeometriesMultiPolygon;
use MStaack\LaravelPostgis\Geometries\Point;
use Shapefile\Geometry\MultiPoint;
use Shapefile\Geometry\MultiPolygon;
use Shapefile\Shapefile;
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

                    $accuracy = $Geometry->getDataArray()['ACCURACY'] ?? null;
                    $details = $Geometry->getDataArray()['DETAILS'] ?? '';
                    $pgaValue = $Geometry->getDataArray()['PGA_VALUE'];
                    $soatoStr = $Geometry->getDataArray()['SOATO'];
                    $soatosArr = explode(',', $soatoStr);
                    $district_soatos = District::pluck('soato')->toArray();
                    $region_soatos = District::pluck('region_soato')->toArray();

                    foreach ($soatosArr as $key => $soato) {
                        if (!in_array($soato, [...$district_soatos, ...$region_soatos]))
                            throw ValidationException::withMessages([
                                'zip' => "$soato soato kodi bazada topilmadi, tekshirib qaytadan urunib ko'ring!",
                            ]);
                    }

                    $shape_json = json_decode($Geometry->getGeoJSON());
                    $multi_polygon = new MultiPolygon();
                    $multi_polygon = $shape_json->type == 'Polygon' ? $multi_polygon->addPolygon($Geometry) : $Geometry;

                    $zone = Zone::updateOrCreate(
                        [
                            'accuracy' => $accuracy,
                            'pga_value' => $pgaValue,
                            'soato' => $soatoStr
                        ],
                        [
                            'details' => $details,
                            'geom' => $multi_polygon->getWKT()
                        ]
                    );

                    foreach ($soatosArr as $key => $value) {
                        DB::table('area_layer')->insert([
                            'area_soato' => $value,
                            'layer_id' => $zone->id,
                            'layer_type' => 'zone'
                        ]);
                    }

                    ShapeImportLog::create([
                        'type' => 'Zona',
                        // 'comment' => "$pgaValue zona oralig'i va $soatoStr soato kodlar bn PGA sheypfayli yuklandi!"
                        'comment' => "zona oralig'i: $pgaValue va soato kodi: $soatoStr bo'lgan PGA qatlami yuklandi!"
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

                    $accuracy = $Geometry->getDataArray()['ACCURACY'] ?? null;
                    $details = $Geometry->getDataArray()['DETAILS'] ?? '';
                    $level = $Geometry->getDataArray()['BALL_VALUE'];
                    $soatoStr = $Geometry->getDataArray()['SOATO'];
                    $soatosArr = explode(',', $soatoStr);
                    $district_soatos = District::pluck('soato')->toArray();
                    $region_soatos = District::pluck('region_soato')->toArray();

                    foreach ($soatosArr as $key => $soato) {
                        if (!in_array($soato, [...$district_soatos, ...$region_soatos]) && $soato != 17)
                            throw ValidationException::withMessages([
                                'zip' => "$soato soato kodi bazada topilmadi, tekshirib qaytadan urunib ko'ring!",
                            ]);
                    }

                    $shape_json = json_decode($Geometry->getGeoJSON());
                    $multi_polygon = new MultiPolygon();
                    $multi_polygon = $shape_json->type == 'Polygon' ? $multi_polygon->addPolygon($Geometry) : $Geometry;

                    $ball = Ball::updateOrCreate(
                        [
                            'accuracy' => $accuracy,
                            'level' => $level,
                            'soato' => $soatoStr
                        ],
                        [
                            'details' => $details,
                            'geom' => $multi_polygon->getWKT()
                        ]
                    );

                    foreach ($soatosArr as $key => $value) {
                        DB::table('area_layer')->insert([
                            'area_soato' => $value,
                            'layer_id' => $ball->id,
                            'layer_type' => 'ball'
                        ]);
                    }

                    ShapeImportLog::create([
                        'type' => 'Ball',
                        'comment' => "darajasi: $level, soato kodi: $soatoStr va aniqlik darajsi: $accuracy bo'lgan Ball qatlami yuklandi!"
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
