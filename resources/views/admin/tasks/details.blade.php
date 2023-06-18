@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Details</h1>
    <p>Gebruiker Naam: {{ $userTask->user->name }}</p>
    <p>Gebruiker Email: {{ $userTask->user->email }}</p>
    <p>Taak Naam: {{ $userTask->task->task_name }}</p>
    <p>Datum: {{ $userTask->task->date }}</p>
    <p>Status: {{ $userTask->status }}</p>
    <p>Admit: {{ $userTask->admit ? 'Goedgekeurd' : 'Niet Goedgekeurd' }}</p>
</div>
@endsection