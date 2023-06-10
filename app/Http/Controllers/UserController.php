<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\UserTask;
use App\Models\Address;
use App\Models\Client;
use App\Models\Role;
use App\Notifications\UserApproved;
use App\Notifications\AssignmentApproved;
use App\Notifications\TaskAccepted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\RoleRequestNotification;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:lid'); // Zorg ervoor dat alleen admins toegang hebben
    }

    public function index()
    {
        $userTasks = UserTask::where('user_id', Auth::id())->get();
        return view('lid.openAssignments', compact('userTasks')); // Toon de view met de opdrachten die bij deze user horen
    }
    public function memberBecomeClient()
    {
        return view('lid.become_client'); // Toon de view met de opdrachten die bij deze user horen
    }
  
    public function accept(UserTask $userTask)
    {
        $userTask->status = 'geaccepteerd';
        $userTask->save(); // Accepteer de opdracht goed en sla het op
        $coordinator = User::find($userTask->assigned_by);
        $user = User::find($userTask->user_id);
        $coordinator->notify(new TaskAccepted($userTask->task, $userTask->status, $user));
        return back()->with('status', 'Opdracht geaccepteerd.'); // Keer terug naar de vorige pagina met een succesbericht
    }

    public function maybe(UserTask $userTask)
    {
        $userTask->status = 'misschien';
        $userTask->save(); // Accepteer de opdracht goed en sla het op
        $coordinator = User::find($userTask->assigned_by);
        $user = User::find($userTask->user_id);
        $coordinator->notify(new TaskAccepted($userTask->task, $userTask->status, $user));    
        return back()->with('status', 'Opdracht op misschien gezet.');  return back()->with('status', 'Opdracht op ik weet het niet gezet.'); // Keer terug naar de vorige pagina met een succesbericht
    }

    public function decline(UserTask $userTask)
    {
        $userTask->status = 'geweigerd';
        $userTask->save(); // Accepteer de opdracht goed en sla het op
        $coordinator = User::find($userTask->assigned_by);
        $user = User::find($userTask->user_id);
        $coordinator->notify(new TaskAccepted($userTask->task, $userTask->status, $user)); 
        return back()->with('status', 'Opdracht geweigerd.'); // Keer terug naar de vorige pagina met een succesbericht
    }
public function submitBecomeClient(Request $request)
{
    $user = Auth::user();

    // Controleer of de gebruiker al de rol 'opdrachtgever' heeft
    if($user->hasRole('opdrachtgever')) {
  
        // Controleer of de aanvraag van de gebruiker al is goedgekeurd
        if($user->is_approved_client) {
            // Als de aanvraag van de gebruiker is goedgekeurd, stuur ze dan door naar de 'task.create' route
            return redirect()->route('task.create');
        } else {
            // Als de aanvraag van de gebruiker nog niet is goedgekeurd, laat ze dan weten dat ze moeten wachten op goedkeuring
            return back()->with('info', 'Je aanvraag om opdrachtgever te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
        }
    }

    $validatedData = $this->validateClientRequest($request);

    DB::transaction(function () use ($validatedData, $user) {
        $address = new Address([
            'street_name' => $validatedData['street'],
            'city' => $validatedData['city'],
            'postal_code' => $validatedData['postal_code'],
            'house_number' => $validatedData['house_number'],
        ]);

        $address->save();

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

        // Stel is_approved_client in op false
        $user->is_approved_client = false;
        $user->save();
        $coordinator = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->first(); // Vind de coördinator
       $coordinator->notify(new RoleRequestNotification($role, $user)); // Stuur de notificatie
    });
    // return back()->with('success', 'Je aanvraag om opdrachtgever te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');

    return redirect()->route('task.index')->with('success', 'Je aanvraag om een opdrachtgever te worden is in behandeling genomen.');
}

private function validateClientRequest($request)
{
    $rules['street'] = ['required', 'string', 'max:255'];
    $rules['city'] = ['required', 'string', 'max:255'];
    $rules['postal_code'] = ['required', 'string','regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/'];
    $rules['house_number'] = ['required', 'numeric'];
    $rules['company_name'] = ['required', 'string', 'max:255'];
    $rules['billing_email'] = ['required', 'string', 'email', 'max:255'];
    $rules['contact_person'] = ['required', 'string', 'max:255'];
    $rules['contact_person_phone']=['required', 'digits:10'];

    return $request->validate($rules);
}
public function checkClientStatus()
    {
        $user = Auth::user();

        // Als de gebruiker de rol 'opdrachtgever' heeft...
        if($user->hasRole('opdrachtgever')) {

            // Als de aanvraag van de gebruiker al is goedgekeurd...
            if($user->is_approved_client) {

                // Stuur ze dan naar de 'task.create' route
                return redirect()->route('task.create');

            } else {

                // Als de aanvraag van de gebruiker nog niet is goedgekeurd, laat ze dan weten dat ze moeten wachten op goedkeuring
                return back()->with('warning', 'Je aanvraag om opdrachtgever te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
            }
        }

        // Als de gebruiker niet de rol 'opdrachtgever' heeft, stuur ze dan naar de 'become_client' route
        return redirect()->route('member.become_client');
    }
}


