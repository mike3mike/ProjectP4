<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Notifications\UserApproved;
use App\Notifications\AssignmentApproved;


class AdminApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:coordinator'); // Zorg ervoor dat alleen coördinators toegang hebben
    }

    public function index()
    {
        $members = User::whereHas('roles', function ($query) {
            $query->where('name', 'lid');
        })->where('is_approved_member', false)->get();
    
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'opdrachtgever');
        })->where('is_approved_client', false)->get();
    
        $coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->where('is_approved_coordinator', false)->get();
    
        return view('admin.approvals.index', compact('members', 'clients', 'coordinators')); // Toon de view met deze gebruikers
    }

  
   public function approveMember(User $user)
    {
        $user->is_approved_member = true;
        $user->save(); // Keur de lid goed en sla het op
        $user->notify(new UserApproved());
        return back()->with('status', 'Lid goedgekeurd.'); // Keer terug naar de vorige pagina met een succesbericht
    }

    public function approveClient(User $user)
    {
        $user->is_approved_client = true;
        $user->save(); // Keur de opdrachtgever goed en sla het op
        $user->notify(new UserApproved());
        return back()->with('status', 'Opdrachtgever goedgekeurd.'); // Keer terug naar de vorige pagina met een succesbericht
    }

    public function approveCoordinator(User $user)
    {
        $user->is_approved_coordinator = true;
        $user->save(); // Keur de coördinator goed en sla het op
        $user->notify(new UserApproved());
        return back()->with('status', 'Coördinator goedgekeurd.'); // Keer terug naar de vorige pagina met een succesbericht
    }

    public function destroy(User $user)
    {
        $user->delete(); // Verwijder de gebruiker

        return back()->with('status', 'Gebruiker verwijderd.'); // Keer terug naar de vorige pagina met een succesbericht
    }



    public function getAssignmentRequests()
    {
        $tasks = Task::get(); // Haal de opdrachten op die nog niet geaccepteerd zijn

        return view('admin.approvals.newAssignmentOverview', compact('tasks')); // Toon de view met de opdrachten
    }

    public function approveAssignment(Task $task)
    {
        $task->status = 'lopend';
        $task->save(); // Keur de opdracht goed en sla het op
        $user = User::find($task->client_id);
        $user->notify(new AssignmentApproved($task));
        return back()->with('status', 'Opdracht goedgekeurd.'); // Keer terug naar de vorige pagina met een succesbericht
    }
    
}

