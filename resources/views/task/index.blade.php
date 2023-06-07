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
        <a href="{{ route('task.create') }}" class="btn btn-primary">Nieuwe Opdracht</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Opdrachtnaam</th>
                <th>Opdrachtnummer</th>
                <th>status</th>
                <!-- Voeg hier extra kolommen toe voor elke attribuut die je wilt weergeven -->
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_number }}</td>
                    <td>{{ $task->status }}</td>
                    <!-- Zorg ervoor dat je de waarden van de extra attributen hier ook toevoegt -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
