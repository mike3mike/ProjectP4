<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function __construct()
    {
        // Alleen geauthenticeerde gebruikers kunnen toegang hebben tot de methoden van deze controller
        $this->middleware('auth');

        // Alleen gebruikers met de rol 'opdrachtgever' kunnen toegang hebben tot de methoden van deze controller
        $this->middleware('role:opdrachtgever,coordinator');
     
    }
    public function index()
    {
        $tasks = Task::where('client_id', Auth::id())->get();
        // $opdrachten = Task::all();

        return view('task.index', compact('tasks'));
    }
    public function create()
    {
        // Return de view voor het aanmaken van een opdracht
        return view('task.create');
    }
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'opdrachtnaam' => 'required',
        'opdrachtnummer' => 'required',
        'datum' => 'required|date',
        'kader_instructeur' => 'required',
        'speellocatie_naam' => 'required',
        'speellocatie' => 'required|array',
        'speellocatie.city' => 'required',
        'speellocatie.street' => 'required',
        'speellocatie.house_number' => 'required',
        'speellocatie.postcode' => 'required',
        'begintijd' => 'required',
        'eindtijd' => 'required',
        'description' => 'required',
        'same_address' => 'sometimes',
        'griemlocatie' => 'nullable|array',
        'griemlocatie.city' => 'sometimes|required',
        'griemlocatie.street' => 'sometimes|required',
        'griemlocatie.house_number' => 'sometimes|required',
        'griemlocatie.postcode' => 'sometimes|required',
        'soort_opdracht' => 'required|array',
        'soort_opdracht.*' => 'in:BHV,EHBO,Examen',           
    ]);

    DB::beginTransaction();

    try {
        $playLocation = $this->createAddress($validatedData['speellocatie']);
        
        $makeupLocation = isset($validatedData['same_address']) 
            ? $playLocation 
            : $this->createAddress($validatedData['griemlocatie']);
        
        $this->createTask($validatedData, $playLocation->id, $makeupLocation->id);

        DB::commit();

        return redirect()->route('task.index')->with('success', 'Opdracht succesvol aangemaakt!');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van de opdracht. Probeer het opnieuw.']);
    }
}

private function createAddress($data)
{
    $address = new Address;
    $address->street_name = $data['street'];
    $address->house_number = $data['house_number'];
    $address->postal_code = $data['postcode'];
    $address->city = $data['city'];
    $address->save();

    return $address;
}

private function createTask($data, $playLocationId, $makeupLocationId)
{
    $taskTypes = json_encode($data['soort_opdracht']);

    $task = new Task;
    $task->task_name = $data['opdrachtnaam'];
    $task->task_number = $data['opdrachtnummer'];
    $task->date = $data['datum'];
    $task->instructor_name = $data['kader_instructeur'];
    $task->play_address_name = $data['speellocatie_naam'];
    $task->begin_time = $data['begintijd'];
    $task->end_time = $data['eindtijd'];
    $task->task_type = $taskTypes;
    $task->description = $data['description'];
    $task->play_address_id = $playLocationId;
    $task->makeup_address_id = $makeupLocationId;
    $task->client_id = Auth::id();

    $task->save();
}
}
