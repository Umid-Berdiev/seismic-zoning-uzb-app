<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DsrSectionController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadShapefileController;
use App\Http\Controllers\UserController;
use App\Models\DsrSection;
use App\Models\Region;
use App\Models\ShapeImportLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('map');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('profile', function () {
        return Inertia::render('Admin/Profile');
    })->name('profile');
    Route::put('profile', [UserController::class, 'updateProfile'])
        ->name('profile.update');
    Route::get('profile/password', function () {
        return Inertia::render('Admin/PasswordUpdatePage');
    })->name('profile.password');
    Route::post('profile/password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::get('dashboard', fn () => redirect()->route('map'))
        ->name('dashboard');
    Route::get('map', [MapController::class, 'index'])
        ->name('map');
    Route::get('map/smr-layer-data', [MapController::class, 'fetchSmrLayers'])
        ->name('map-smr-layer-data');
    Route::get('map/dsr-layer-data', [MapController::class, 'fetchDsrLayers'])
        ->name('map-dsr-layer-data');
    Route::get('map/search', [MapController::class, 'searchLayers'])
        ->name('map-search');
    Route::get('map/accuracy', [MapController::class, 'fetchLayersByAccuracy'])
        ->name('map-accuracy');
    Route::get('map/point-in-polygon', [MapController::class, 'findPointInPolygon'])
        ->name('map-point-in-polygon');
    Route::get('statics', function () {
        $logs = ShapeImportLog::latest('id')->paginate();
        return Inertia::render('Admin/Statics', [
            'logs' => $logs
        ]);
    })
        ->name('statics');
    Route::resource('users', UserController::class);

    Route::prefix('directory')->group(function () {
        Route::get('dsr-sections/list', function (Request $request) {
            return DsrSection::with('regions')->get(['id', 'soatos', 'name']);
        });
        Route::resource('dsr-sections', DsrSectionController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('roles', RoleController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::get('regions/{region}/districts', [DistrictController::class, 'index'])
            ->name('districts.index');
        Route::put('districts/{district}', [DistrictController::class, 'update'])
            ->name('districts.update');
        Route::get('districts/{region}', [DistrictController::class, 'export'])
            ->name('districts.export');
        Route::get('regions/export', [RegionController::class, 'export'])
            ->name('regions.export');
        Route::resource('regions', RegionController::class)
            ->only(['index', 'update']);
    });
    Route::get('regions', function (Request $request) {
        return Region::with('districts')->get(['id', 'soato', 'name_uz']);
    });

    Route::post('zones/import/shapefile', [UploadShapefileController::class, 'zonesImportShapefile'])->name('zones.import.shape_file');
    Route::post('balls/import/shapefile', [UploadShapefileController::class, 'ballsImportShapefile'])->name('balls.import.shape_file');
    Route::post('borders/import/shapefile', [UploadShapefileController::class, 'bordersImportShapefile'])->name('borders.import.shape_file');
    Route::post('segments/import/shapefile', [UploadShapefileController::class, 'segmentsImportShapefile'])->name('segments.import.shape_file');
});

require __DIR__ . '/auth.php';
