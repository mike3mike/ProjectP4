@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Opdracht Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $task->task_name }}</h5>
            <p class="card-text">
                <strong>Opdrachtnummer:</strong> {{ $task->task_number }}<br>
                <strong>Datum:</strong> {{ $task->date }}<br>
                <strong>Kader Instructeur:</strong> {{ $task->instructor_name }}<br>
                <strong>Speellocatie Naam:</strong> {{ $task->play_address_name }}<br>
                <strong>Speellocatie:</strong> {{ $task->playAddress->city }}, {{ $task->playAddress->street_name }}, {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}<br>
                <strong>Begintijd:</strong> {{ $task->begin_time }}<br>
                <strong>Eindtijd:</strong> {{ $task->end_time }}<br>
                <strong>Beschrijving:</strong> {{ $task->description }}<br>
                <strong>Maximaal aantal gebruikers:</strong> {{ $task->max_users }}<br>
                <strong>Griemlocatie:</strong> {{ $task->makeupAddress->city }}, {{ $task->makeupAddress->street_name }}, {{ $task->makeupAddress->house_number }}, {{ $task->makeupAddress->postal_code }}<br>
                <strong>Status:</strong> {{ $task->status }}<br>
                <strong>Soort Opdracht:</strong> {{ $task->task_type }}<br>
            </p>
        </div>
    </div>

    <a href="{{ route('task.index') }}" class="btn btn-primary mt-3">Terug naar Opdrachten</a>
</div>
@endsection