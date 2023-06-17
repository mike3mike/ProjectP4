<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTask;
use App\Models\Task;
use App\Notifications\TaskStatusUpdated;
use Illuminate\Http\Request;

class AdminMemberTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:coordinator');
    }
    public function index()
    {
        // $userTasks = UserTask::with(['user', 'task'])->get();

        // return view('admin.tasks.index', compact('userTasks'));
        $tasks = Task::with('userTasks.user')->get();

    // maak een nieuwe collectie die het aantal toegelaten gebruikers per taak bevat
    $taskAdmits = $tasks->mapWithKeys(function ($task) {
        return [$task->id => $task->userTasks->where('admit', true)->where('status', 'geaccepteerd')->count()];
    });
    return view('admin.tasks.index', compact('tasks', 'taskAdmits'));
    }

    public function approve(UserTask $userTask)
{
    $task = $userTask->task;
    $taskAdmits = $task->userTasks->where('admit', true)->where('status', 'geaccepteerd')->count();

    if($taskAdmits >= $task->max_users) {
        return back()->with('error', 'Maximum aantal gebruikers voor deze taak is al bereikt');
    }

    if ($userTask->status === 'geaccepteerd' || $userTask->status === 'misschien') {
        $userTask->update([
            'admit' => true,
        ]);

        // Stuur notificatie naar de gebruiker
        $userTask->user->notify(new TaskStatusUpdated('Jouw deelname is goedgekeurd'));

        return back()->with('success', 'De deelname van de gebruiker is goedgekeurd');
    } else {
        return back()->with('error', 'De deelname van de gebruiker kan niet worden goedgekeurd');
    }
}

    // public function approve(UserTask $userTask)
    // {
    //     if ($userTask->status === 'geaccepteerd' || $userTask->status === 'misschien') {
    //         $userTask->update([
    //             'admit' => true,
    //         ]);

    //         // Stuur notificatie naar de gebruiker
    //         $userTask->user->notify(new TaskStatusUpdated('Jouw deelname is goedgekeurd'));

    //         return back()->with('success', 'De deelname van de gebruiker is goedgekeurd');
    //     } else {
    //         return back()->with('error', 'De deelname van de gebruiker kan niet worden goedgekeurd');
    //     }
    // }

    public function remove(UserTask $userTask)
    {
        if ($userTask->status === 'geweigerd') {
            // Stuur notificatie naar de gebruiker voor het verwijderen
            $userTask->user->notify(new TaskStatusUpdated('Jouw deelname is afgewezen'));

            $userTask->delete();

            return back()->with('success', 'De deelname van de gebruiker is afgewezen');
        } else {
            return back()->with('error', 'De deelname van de gebruiker kan niet worden afgewezen');
        }
    }
    public function details(UserTask $userTask)
    {
         return view('admin.tasks.details', ['userTask' => $userTask]);
    }
    public function showTask(Task $task)
    {      
        $task->load('userTasks.user');
        
        $taskAdmits = $task->userTasks->where('admit', true)->where('status', 'geaccepteerd')->count();
    
        return view('admin.tasks.ex', compact('task', 'taskAdmits'));
    }
    
}
