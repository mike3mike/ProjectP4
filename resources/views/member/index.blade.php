@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <h1>Opdrachten</h1>
        <a href="{{ route('task.submit_become_client') }}" class="btn btn-primary">Nieuwe Opdracht</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Opdrachtnaam</th>
                <th>Opdrachtnummer</th>
                <th>Status</th>
                <th>Acties</th>
    
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_number }}</td>
                    <td>{{ $task->status }}</td>
                 
                    <td>
                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-info">Bekijk Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
