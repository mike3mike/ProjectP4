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

class ProfileController extends Controller
{
    public function edit(User $user)
    {
        // controleren of de geauthenticeerde gebruiker zijn eigen profiel probeert te bewerken
        if(auth()->user()->id !== $user->id) {
            return redirect('/')->with('error', 'Ongeautoriseerde Pagina');
        }
        
        // het doorgeven van de $user aan de view
        return view('profile.edit', compact('user'));
    }
 public function submitBecomeCoordinator(Request $request)
{
    $user = Auth::user();

    // Controleer of de gebruiker al de rol 'coördinator' heeft
    if($user->hasRole('coördinator')) {
        // Controleer of de aanvraag van de gebruiker al is goedgekeurd
        if($user->is_approved_coordinator) {
            // Als de aanvraag van de gebruiker is goedgekeurd, stuur ze dan door naar de juiste route
            return redirect()->route('admin.approvals.index'); // Pas dit aan naar de juiste route
        } else {
            // Als de aanvraag van de gebruiker nog niet is goedgekeurd, laat ze dan weten dat ze moeten wachten op goedkeuring
            return back()->with('info', 'Je aanvraag om coördinator te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
        }
    }

    // Opslaan van de rol 'coördinator' voor de gebruiker
    $role = Role::where('name', 'coördinator')->first();
    $user->roles()->attach($role);

    // Stel is_approved_coordinator in op false
    $user->is_approved_coordinator = false;
    $user->save();

    // Stuur een melding naar de beheerder (pas dit aan naar wie dan ook de aanvragen moet goedkeuren)
    $admin = User::whereHas('roles', function ($query) {
        $query->where('name', 'coordinator');
    })->first();
    $admin->notify(new RoleRequestNotification($role, $user));

    return back()->with('success', 'Je aanvraag om coördinator te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');
}
public function submitBecomeClient(Request $request)
{
    $user = Auth::user();
    // dd($user);
    // dd($request);

    // Controleer of de gebruiker al de rol 'opdrachtgever' heeft
    if ($user->hasRole('opdrachtgever')) {

        // Controleer of de aanvraag van de gebruiker al is goedgekeurd
        if ($user->is_approved_client) {
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
    return back()->with('success', 'Je aanvraag om opdrachtgever te worden is nog in behandeling. Wacht alstublieft op goedkeuring.');

    // return redirect()->route('profile.edit')->with('success', 'Je aanvraag om een opdrachtgever te worden is in behandeling genomen.');
}

private function validateClientRequest($request)
{
    $rules['street'] = ['required', 'string', 'max:255'];
    $rules['city'] = ['required', 'string', 'max:255'];
    $rules['postal_code'] = ['required', 'string', 'regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/'];
    $rules['house_number'] = ['required', 'numeric'];
    $rules['company_name'] = ['required', 'string', 'max:255'];
    $rules['billing_email'] = ['required', 'string', 'email', 'max:255'];
    $rules['contact_person'] = ['required', 'string', 'max:255'];
    $rules['contact_person_phone'] = ['required', 'digits:10'];

    return $request->validate($rules);
}
public function memberBecomeClient()
{
    return view('profile.become_client'); // Toon de view met de opdrachten die bij deze user horen
}
}
