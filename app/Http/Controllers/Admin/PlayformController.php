<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF; // Use the PDF facade we have set up

class PlayformController extends Controller
{
    public function downloadPlayform()
    {
        // Here we fetch all the data that you need for the playform.
        // I've put an empty array here as a placeholder, but you should replace this
        // with the actual data you want to display on the playform.
        $data = [];

        // Load the view and pass the data. 
        // Change 'playformview' to the name of the view file you want to use.
        $pdf = PDF::loadView('playformview', $data);

        // Set the paper size to A4
        $pdf->setPaper('A4', 'portrait');

        // Download the PDF with the name 'playform.pdf'
        return $pdf->download('playform.pdf');
    }
}
