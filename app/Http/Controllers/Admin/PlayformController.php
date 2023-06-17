<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use PDF; // Use the PDF facade we have set up

class PlayformController extends Controller
{
    // public function downloadPlayform()
    // {
    //     // Here we fetch all the data that you need for the playform.
    //     // I've put an empty array here as a placeholder, but you should replace this
    //     // with the actual data you want to display on the playform.
    //     $data = [];

    //     PDF::setOptions(['dpi' => 72, 'defaultFont' => 'sans-serif']);
    //     // Load the view and pass the data. 
      
    //     $pdf = PDF::loadView('playformview', $data);

    //     // Set the paper size to A4
    //     $pdf->setPaper('A4', 'portrait');

    //     // Download the PDF with the name 'playform.pdf'
    //     return $pdf->download('playform.pdf');
    // }
    public function downloadPlayform($taskId)
{
    // Eerst halen we de task op uit de database.
    // $task = Task::with(['client', 'client.address', 'makeupAddress', 'playAddress', 'userTasks'])->find($taskId);
    $task = Task::with(['client', 'client.address','makeupAddress', 'playAddress', 'userTasks' => function ($query) {
        $query->where('status', 'geaccepteerd')->where('admit', 1);
    }])->find($taskId);

    
    // Vervolgens maken we een array met data die we naar de view willen sturen.
    $data = [
        'task' => $task,
        // Hier kunt u andere data toevoegen die u in uw view wilt gebruiken.
    ];

    PDF::setOptions(['dpi' => 72, 'defaultFont' => 'sans-serif']);

    // We laden de view en geven de data door.
    $pdf = PDF::loadView('playformview', $data);

    // Stel het papierformaat in op A4
    $pdf->setPaper('A4', 'portrait');

    // Download de PDF met de naam 'playform.pdf'
    return $pdf->download('playform.pdf');
}

}
