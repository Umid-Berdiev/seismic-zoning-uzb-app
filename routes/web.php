<?php

use App\Http\Controllers\GroundwaterDataController;
use App\Http\Controllers\GroundwaterLevelPointerController;
use App\Http\Controllers\GroundwaterMineralizationPointerController;
use App\Http\Controllers\GumusPointerController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SoilActivePotassiumPointerController;
use App\Http\Controllers\SoilAppraisalPointerController;
use App\Http\Controllers\SoilDataController;
use App\Http\Controllers\SoilMineralStructurePointerController;
use App\Http\Controllers\SoilMobilePhosphorusPointerController;
use App\Http\Controllers\SoilSalinityPointerController;
use App\Http\Controllers\UploadShapefileController;
use App\Http\Controllers\UserController;
use App\Models\GroundwaterLevelPointer;
use App\Models\GroundwaterMineralizationPointer;
use App\Models\GumusPointer;
use App\Models\ShapeImportLog;
use App\Models\SoilActivePotassiumPointer;
use App\Models\SoilAppraisalPointer;
use App\Models\SoilDataLog;
use App\Models\SoilMineralStructurePointer;
use App\Models\SoilMobilePhosphorusPointer;
use App\Models\SoilSalinityPointer;
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
    return redirect()->route('dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', fn () => Inertia::render('Admin/Dashboard'))
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
    });

    Route::post('balls/import/shapefile', [UploadShapefileController::class, 'ballsImportShapefile'])->name('balls.import.shape_file');
    Route::post('borders/import/shapefile', [UploadShapefileController::class, 'bordersImportShapefile'])->name('borders.import.shape_file');
});

require __DIR__ . '/auth.php';
