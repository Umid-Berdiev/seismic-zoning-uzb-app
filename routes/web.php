<?php

use App\Http\Controllers\GroundwaterDataController;
use App\Http\Controllers\GroundwaterLevelPointerController;
use App\Http\Controllers\GroundwaterMineralizationPointerController;
use App\Http\Controllers\GumusPointerController;
use App\Http\Controllers\SoilActivePotassiumPointerController;
use App\Http\Controllers\SoilAppraisalPointerController;
use App\Http\Controllers\SoilDataController;
use App\Http\Controllers\SoilMineralStructurePointerController;
use App\Http\Controllers\SoilMobilePhosphorusPointerController;
use App\Http\Controllers\SoilSalinityPointerController;
use App\Models\GroundwaterLevelPointer;
use App\Models\GroundwaterMineralizationPointer;
use App\Models\GumusPointer;
use App\Models\SoilActivePotassiumPointer;
use App\Models\SoilAppraisalPointer;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'soilGumusData' => GumusPointer::latest('id')->take(3)->get(),
        'groundwaterMineralizationData' => GroundwaterMineralizationPointer::latest('id')->take(3)->get(),
        'groundwaterLevelData' => GroundwaterLevelPointer::latest('id')->take(2)->get(),
        'soilAppraisalData' => SoilAppraisalPointer::latest('id')->take(3)->get(),
        'soilActivePotassiumData' => SoilActivePotassiumPointer::latest('id')->take(3)->get(),
        'soilMechanicStructureData' => SoilMineralStructurePointer::latest('id')->take(3)->get(),
        'soilActivePhosphorusData' => SoilMobilePhosphorusPointer::latest('id')->take(3)->get(),
        'soilSalinityData' => SoilSalinityPointer::latest('id')->take(3)->get(),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
        ->name('dashboard');

    Route::get('soil_data', [SoilDataController::class, 'index'])
        ->name('admin.soil_data');

    Route::get('groundwater_data', [GroundwaterDataController::class, 'index'])
        ->name('admin.groundwater_data');

    // gumus
    Route::post('gumus_pointers/import', [GumusPointerController::class, 'import'])
        ->name('gumus_pointers_import');
    Route::resource('gumus_pointers', GumusPointerController::class);

    // bonitirovka
    Route::post('soil_appraisal_pointers/import', [SoilAppraisalPointerController::class, 'import'])
        ->name('soil_appraisal_pointers_import');
    Route::resource('soil_appraisal_pointers', SoilAppraisalPointerController::class);

    // salinity
    Route::post('soil_salinity_pointers/import', [SoilSalinityPointerController::class, 'import'])
        ->name('soil_salinity_pointers_import');
    Route::resource('soil_salinity_pointers', SoilSalinityPointerController::class);

    // mineral_structure
    Route::post('soil_mineral_structure_pointers/import', [SoilMineralStructurePointerController::class, 'import'])
        ->name('soil_mineral_structure_pointers_import');
    Route::resource('soil_mineral_structure_pointers', SoilMineralStructurePointerController::class);

    // soil_mobile_phosphorus
    Route::post('soil_mobile_phosphorus_pointers/import', [SoilMobilePhosphorusPointerController::class, 'import'])
        ->name('soil_mobile_phosphorus_pointers_import');
    Route::resource('soil_mobile_phosphorus_pointers', SoilMobilePhosphorusPointerController::class);

    // soil_active_potassium
    Route::post('soil_active_potassium_pointers/import', [SoilActivePotassiumPointerController::class, 'import'])
        ->name('soil_active_potassium_pointers_import');
    Route::resource('soil_active_potassium_pointers', SoilActivePotassiumPointerController::class);

    // groundwater_level
    Route::post('groundwater_level_pointers/import', [GroundwaterLevelPointerController::class, 'import'])
        ->name('groundwater_level_pointers_import');
    Route::resource('groundwater_level_pointers', GroundwaterLevelPointerController::class);

    // groundwater_mineralization
    Route::post('groundwater_mineralization_pointers/import', [GroundwaterMineralizationPointerController::class, 'import'])
        ->name('groundwater_mineralization_pointers_import');
    Route::resource('qw_mineralization_pointers', GroundwaterMineralizationPointerController::class);
});

require __DIR__ . '/auth.php';
