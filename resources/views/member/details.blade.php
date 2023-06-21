@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Opdracht Details</h1>

    <div class="card">
        <div class="card-body">
            <p class="card-text">
                <strong>Opdrachtnaam:</strong> {{ $task->task_name }}<br>
                <strong>Opdrachtnummer:</strong> {{ $task->id }}<br>
                <strong>Datum:</strong> {{ $task->date }}<br>
                <strong>Kader Instructeur:</strong> {{ $task->instructor_name }}<br>
                <strong>Speellocatie Naam:</strong> {{ $task->play_address_name }}<br>
                <strong>Speellocatie:</strong> {{ $task->playAddress->city }}, {{ $task->playAddress->street_name }}, {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}<br>
                <strong>Begintijd:</strong> {{ $task->begin_time }}<br>
                <strong>Eindtijd:</strong> {{ $task->end_time }}<br>
                <strong>Beschrijving:</strong> {{ $task->description }}<br>
                <strong>Maximaal aantal deelnemers:</strong> {{ $task->max_users }}<br>
                <strong>Griemlocatie:</strong> {{ $task->makeupAddress->city }}, {{ $task->makeupAddress->street_name }}, {{ $task->makeupAddress->house_number }}, {{ $task->makeupAddress->postal_code }}<br>
                <strong>Status:</strong> {{ $task->status }}<br>
                <strong>Soort Opdracht:</strong> {{ $task->task_type }}<br>
            </p>
        </div>
    </div>
</div>
@endsection