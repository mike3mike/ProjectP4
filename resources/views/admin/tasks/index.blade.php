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
                <th>Status</th>
                <th>Gevulde Plekken</th>
                <th>Aanmeldingen</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach ($tasks as $task)
      
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->date }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $taskAdmits[$task->id] }}/{{ $task->max_users }}</td>
                        <td>{{ $task->userTasks->where('admit', 0)->count() }}</td>
                        <td>
                            {{-- {{ dump($task) }} --}}
                            <form action="{{ route('admin.tasks.showTask', $task) }}" method="get" class="mt-2">
                                <button type="submit" class="btn btn-info">Bekijken</button>
                            </form>
                        </td>
                    </tr>
       
            @endforeach
        </tbody>
    </table>
</div>
@endsection
