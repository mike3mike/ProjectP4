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
        'max_users' => 'required|numeric',
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
    return view('task.show', compact('task'));
}
public function showAdmin($id)
{
    // Eager load de relaties om extra database queries te vermijden
    $task = Task::with(['playAddress', 'makeupAddress','client.user'])->find($id);

    // Als de taak niet wordt gevonden, stuur dan een 404 response
    if (!$task) {
        abort(404);
    }

    // Return de view voor het tonen van een taak
    return view('task.show_task_details_admin', compact('task'));
}
public function submitBecomeClient(Request $request)

{
    $user = Auth::user();

    // Controleer of de gebruiker al de rol 'opdrachtgever' heeft
    if($user->hasRole('opdrachtgever')) {
        // Controleer of de aanvraag van de gebruiker al is goedgekeurd
        if($user->is_approved) {
            // Als de aanvraag van de gebruiker is goedgekeurd, stuur ze dan door naar de 'task.create' route
            return redirect()->route('task.create');
        } else {
            // Als de aanvraag van de gebruiker nog niet is goedgekeurd, laat ze dan weten dat ze moeten wachten op goedkeuring
            return back()->with('info', 'Je aanvraag om opdrachtgever te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
        }
    }

    $rules['street'] = ['required', 'string', 'max:255'];
    $rules['city'] = ['required', 'string', 'max:255'];
    $rules['postal_code'] = ['required', 'string','regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/'];
    $rules['house_number'] = ['required', 'numeric'];
    $rules['company_name'] = ['required', 'string', 'max:255'];
    $rules['billing_email'] = ['required', 'string', 'email', 'max:255'];
    $rules['contact_person'] = ['required', 'string', 'max:255'];
    $rules['contact_person_phone']=['required', 'digits:10'];

    $validatedData = $request->validate($rules);

    $address = new Address([
        'street' => $validatedData['street'],
        'city' => $validatedData['city'],
        'postal_code' => $validatedData['postal_code'],
        'house_number' => $validatedData['house_number'],
    ]);

    $address->save();

    $user = Auth::user();

    $client = new Client([
        'user_id' => $user->id,
        'company_name' => $validatedData['company_name'],
        'invoice_email_address' => $validatedData['billing_email'],
        'contact_person_name' => $validatedData['contact_person'],
        'contact_person_phone_number' => $validatedData['contact_person_phone'],
        'invoice_address_id' => $address->id,
    ]);

    $user->client()->save($client);

     // Opslaan van de rol 'opdrachtgever' voor de gebruiker
     $role = Role::where('name', 'opdrachtgever')->first();
     $user->roles()->attach($role);

    return redirect()->route('task.index')->with('success', 'Je aanvraag om een opdrachtgever te worden is in behandeling genomen.');
}
// public function invite(Task $task)
// {
//     $users = User::all(); // Haal alle gebruikers op

//     return view('admin.approvals.invite', [
//         'task' => $task,
//         'users' => $users,
//     ]);
// }
public function invite(Task $task)
{
    $users = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['lid', 'coordinator']);
            })  // Haal alleen leden en coördinatoren op
            ->whereDoesntHave('userTasks', function ($query) use ($task) {
                $query->where('task_id', $task->id);
            })  // Haal alleen gebruikers op die nog niet voor deze taak zijn uitgenodigd
            ->get();

    return view('admin.approvals.invite', [
        'task' => $task,
        'users' => $users,
    ]);
}

public function sendInvitation(Request $request, Task $task)
{
    // Valideer eerst de aanvraag
    $validatedData = $request->validate([
        'users' => ['required', 'array'],
        'users.*' => ['exists:users,id'],
    ]);

    // Haal de geselecteerde gebruikers op
    $users = User::whereIn('id', $validatedData['users'])->get();

    // Stuur een uitnodiging naar elk van de geselecteerde gebruikers
    foreach ($users as $user) {
        // Maak een nieuwe UserTask voor deze uitnodiging
        $userTask = new UserTask([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'assigned_by' => Auth::id() // Zorg ervoor dat de ingelogde gebruiker de toewijzing heeft gedaan
            // 'status' => 'misschien', 
            // 'admit' => false // admit kan leeg blijven totdat de gebruiker het treugstuurt
        ]);

        // Sla de UserTask op in de database
        $userTask->save();

        // Stuur een melding
        $user->notify(new InvitationSent($task));
    }

    return redirect()->route('admin.approvals.getAssignmentsRequests')->with('status', 'Uitnodiging(en) verzonden!');
}

}
