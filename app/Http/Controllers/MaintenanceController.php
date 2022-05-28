<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function top()
    {
        return view('maintenance.top');
    }

}
