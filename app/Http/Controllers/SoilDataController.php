<?php

namespace App\Http\Controllers;

use App\Models\GumusPointer;
use App\Models\SoilDataLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SoilDataController extends Controller
{
    public function index(Request $request)
    {
        $logs = SoilDataLog::latest('id')->paginate(10);

        return Inertia::render('Admin/SoilData', [
            'logs' => $logs
        ]);
    }
}
