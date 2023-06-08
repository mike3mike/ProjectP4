<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\UserTask;
use App\Notifications\UserApproved;
use App\Notifications\AssignmentApproved;
use App\Notifications\TaskAccepted;
use Illuminate\Support\Facades\Auth;


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
}


