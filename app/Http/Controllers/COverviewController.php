<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class COverviewController extends Controller
{
    public function index()
    {
        return view('coordinator.overview');
    }
}
