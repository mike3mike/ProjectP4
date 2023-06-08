<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


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
    $validator = Validator::make($request->all(), [
        'opdrachtnaam' => 'required|string',
        'opdrachtnummer' => 'required|numeric',
        'datum' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        'kader_instructeur' => 'required',
        'speellocatie_naam' => 'required|string',
        'speellocatie' => 'required|array',
        'speellocatie.city' => 'required|string',
        'speellocatie.street' => 'required|string',
        'speellocatie.house_number' => 'required|numeric',
        'speellocatie.postcode' => 'required|regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/',
        'begintijd' => 'required|date_format:H:i',
        'eindtijd' => 'required|date_format:H:i',
        'description' => 'required|string',
        'same_address' => 'sometimes',
        'griemlocatie' => 'nullable|array',
        'griemlocatie.city' => 'sometimes|required|string',
        'griemlocatie.street' => 'sometimes|required|string',
        'griemlocatie.house_number' => 'sometimes|required',
        'griemlocatie.postcode' => 'sometimes|required',
        'soort_opdracht' => ['required', 'array', Rule::in(['BHV', 'EHBO', 'Examen'])],           
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    // $validatedData = $request->validate([
    //     'opdrachtnaam' => 'required',
    //     'opdrachtnummer' => 'required',
    //     'datum' => 'required|date',
    //     'kader_instructeur' => 'required',
    //     'speellocatie_naam' => 'required',
    //     'speellocatie' => 'required|array',
    //     'speellocatie.city' => 'required',
    //     'speellocatie.street' => 'required',
    //     'speellocatie.house_number' => 'required',
    //     'speellocatie.postcode' => 'required',
    //     'begintijd' => 'required',
    //     'eindtijd' => 'required',
    //     'description' => 'required',
    //     'same_address' => 'sometimes',
    //     'griemlocatie' => 'nullable|array',
    //     'griemlocatie.city' => 'sometimes|required',
    //     'griemlocatie.street' => 'sometimes|required',
    //     'griemlocatie.house_number' => 'sometimes|required',
    //     'griemlocatie.postcode' => 'sometimes|required',
    //     'soort_opdracht' => 'required|array',
    //     'soort_opdracht.*' => 'in:BHV,EHBO,Examen',           
    // ]);
      // Get the validated data from the validator
      $validatedData = $validator->validated();

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
        throw $e;
        // return back()->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van de opdracht. Probeer het opnieuw.']);
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
public function submitBecomeClient(Request $request)
{
    $rules['street'] = ['required', 'string', 'max:255'];
    $rules['city'] = ['required', 'string', 'max:255'];
    $rules['postal_code'] = ['required', 'string','regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/'];
    $rules['house_number'] = ['required', 'numeric'];
    $rules['company_name'] = ['required', 'string', 'max:255'];
    $rules['billing_email'] = ['required', 'string', 'email', 'max:255'];
    $rules['contact_person'] = ['required', 'string', 'max:255'];
    $rules['contact_person_phone']=['required', 'digits:10'];

    return redirect()->route('task.index')->with('success', 'Je aanvraag om een opdrachtgever te worden is in behandeling genomen.');
}

}
