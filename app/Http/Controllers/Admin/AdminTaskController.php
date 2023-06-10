<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;
use App\Notifications\InvitationSent;

class AdminTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
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
}