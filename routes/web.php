<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadShapefileController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    // ]);
    return redirect()->route('map');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', fn () => redirect()->route('map'))
        ->name('dashboard');
    Route::get('/map', [MapController::class, 'index'])
        ->name('map');
    Route::get('/statics', function () {
        $logs = ShapeImportLog::latest('id')->paginate();
        return Inertia::render('Admin/Statics', [
            'logs' => $logs
        ]);
    })
        ->name('statics');
    Route::resource('users', UserController::class);

    Route::prefix('directory')->group(function () {
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
});

require __DIR__ . '/auth.php';
