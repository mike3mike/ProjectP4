@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success')) 
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error')) 
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Taak Naam</th>
                <th>Datum</th>
                <th>Gebruiker</th>
                <th>Status</th>
                <th>Admit</th>
                <th>Gevulde Plekken</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                @foreach ($task->userTasks as $userTask)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->date }}</td>
                        <td>{{ $userTask->user->name }} - {{ $userTask->user->email }}</td>
                        <td>{{ $userTask->status }}</td>
                        <td>{{ $userTask->admit ? 'Goedgekeurd' : 'Niet Goedgekeurd' }}</td>
                        <td>{{ $taskAdmits[$task->id] }}/{{ $task->max_users }}</td>
                        <td>
                            <form action="{{ route('admin.tasks.approve', $userTask) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Goedkeuren</button>
                            </form>
                            <form action="{{ route('admin.tasks.remove', $userTask) }}" method="post" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Verwijderen</button>
                            </form>
                            <form action="{{ route('admin.tasks.details', $userTask) }}" method="get" class="mt-2">
                                <button type="submit" class="btn btn-info">Details</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
