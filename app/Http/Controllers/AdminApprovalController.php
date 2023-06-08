<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Notifications\UserApproved;
use App\Notifications\AssignmentApproved;


class AdminApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:coordinator'); // Zorg ervoor dat alleen admins toegang hebben
    }

    public function index()
    {
        $users = User::where('is_approved', false)->get(); // Haal de gebruikers op die nog niet zijn goedgekeurd

        return view('admin.approvals.index', compact('users')); // Toon de view met deze gebruikers
    }

    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save(); // Keur de gebruiker goed en sla het op
        $user->notify(new UserApproved());
        return back()->with('status', 'Gebruiker goedgekeurd.'); // Keer terug naar de vorige pagina met een succesbericht
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
    

    public function inviteMember(Task $task)
    {

    }

}
