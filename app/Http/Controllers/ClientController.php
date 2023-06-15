<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\TaskCreated;
use App\Notifications\InvitationSent;
use App\Notifications\RoleRequestNotification;


class ClientController extends Controller
{
    public function __construct()
    {
        // Alleen geauthenticeerde gebruikers kunnen toegang hebben tot de methoden van deze controller
        $this->middleware('auth');

        // Alleen gebruikers met de rol 'opdrachtgever' kunnen toegang hebben tot de methoden van deze controller
        $this->middleware('role:opdrachtgever,coordinator');
        $this->middleware('approved_for_role:opdrachtgever');
     
    }
    public function index()
    {
        $tasks = Task::where('client_id', Auth::id())->get();
        // $opdrachten = Task::all();

        return view('client.index', compact('tasks'));
    }
    public function create()
    {
        // Return de view voor het aanmaken van een opdracht
        return view('client.create');
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'opdrachtnaam' => 'required|string',
        'opdrachtnummer' => 'required|numeric|max_digits:11',
        'datum' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        'kader_instructeur' => 'required',
        'speellocatie_naam' => 'required|string',
        'speellocatie' => 'required|array',
        'speellocatie.city' => 'required|string',
        'speellocatie.street' => 'required|string',
        'speellocatie.house_number' => 'required|numeric',
        'speellocatie.postcode' => ['required', 'regex:/^([0-9]{4} ?[A-Z]{2})|([0-9]{4} ?[a-z]{2})$/'],
        'begintijd' => 'required|date_format:H:i',
        'eindtijd' => 'required|date_format:H:i',
        'description' => 'required|string',
        'max_users' => 'required|numeric',
        'same_address' => 'sometimes',
        'griemlocatie' => 'nullable|array',
        'griemlocatie.city' => 'sometimes|required|string',
        'griemlocatie.street' => 'sometimes|required|string',
        'griemlocatie.house_number' => 'sometimes|required',
        'griemlocatie.postcode' => ['sometimes','required','regex:/^([0-9]{4} ?[A-Z]{2})|([0-9]{4} ?[a-z]{2})$/'],
        'soort_opdracht' => ['required', 'array', Rule::in(['BHV', 'EHBO', 'Examen'])],           
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
      // Get the validated data from the validator
      $validatedData = $validator->validated();

    DB::beginTransaction();

    try {
        $playLocation = $this->createAddress($validatedData['speellocatie']);
        
        $makeupLocation = isset($validatedData['same_address']) 
            ? $playLocation 
            : $this->createAddress($validatedData['griemlocatie']);
        
            $task = $this->createTask($validatedData, $playLocation->id, $makeupLocation->id);

        // Stuur een e-mail naar de coördinator wanneer een nieuwe taak wordt aangemaakt
        $coordinator = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->first(); // haal de coördinator op. 
                if ($coordinator) {
                      $coordinator->notify(new TaskCreated($task));
                }
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
    $task->max_users = $data['max_users'];
    $task->play_address_id = $playLocationId;
    $task->makeup_address_id = $makeupLocationId;
    $task->client_id = Auth::id();

    $task->save();
    return $task;
}
public function show($id)
{
    // Eager load de relaties om extra database queries te vermijden
    $task = Task::with(['playAddress', 'makeupAddress'])->find($id);

    // Als de taak niet wordt gevonden, stuur dan een 404 response
    if (!$task) {
        abort(404);
    }

    // Return de view voor het tonen van een taak
    return view('client.show', compact('task'));
}


public function submitBecomeMember(Request $request)
{
    $user = Auth::user();

    // Controleer of de gebruiker al de rol 'lid' heeft
    if($user->hasRole('lid')) {
        // Controleer of de aanvraag van de gebruiker al is goedgekeurd
        if($user->is_approved_member) {
            // Als de aanvraag van de gebruiker is goedgekeurd, stuur ze dan door naar de juiste route
            return redirect()->route('member.openAssignments.index');
        } else {
            // Als de aanvraag van de gebruiker nog niet is goedgekeurd, laat ze dan weten dat ze moeten wachten op goedkeuring
            return back()->with('info', 'Je aanvraag om lid te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
        }
    }

    // Opslaan van de rol 'lid' voor de gebruiker
    $role = Role::where('name', 'lid')->first();
    $user->roles()->attach($role);

    // Stel is_approved_member in op false
    $user->is_approved_member = false;
    $user->save();
    $coordinator = User::whereHas('roles', function ($query) {
        $query->where('name', 'coordinator');
    })->first(); // Vind de coördinator
    $coordinator->notify(new RoleRequestNotification($role, $user));
    return back()->with('success', 'Je aanvraag om lid te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');

    // return redirect()->route('member.index')->with('success', 'Je aanvraag om een lid te worden is in behandeling genomen.');
}




}
