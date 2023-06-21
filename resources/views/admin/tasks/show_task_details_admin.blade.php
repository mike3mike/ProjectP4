@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Details van Opdracht {{ $task->id }}</h1>
    <ul class="list-group">
        <li class="list-group-item">Opdracht naam: {{ $task->task_name }}</li>
        <li class="list-group-item">Opdrachtnummer: {{ $task->id }}</li>
        <li class="list-group-item">Soort opdracht: {{ $task->task_type }}</li>
        <li class="list-group-item">Speellocatie adres: {{ $task->playAddress->street_name }} {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->city }}</li>
        <li class="list-group-item">Grimelocatie adres: {{ $task->makeupAddress->street_name }} {{ $task->makeupAddress->house_number }}, {{ $task->makeupAddress->postal_code }}, {{ $task->makeupAddress->city }}</li>
        <li class="list-group-item">Bedrijfsnaam: {{ $task->client->company_name }}</li>
        <li class="list-group-item">Contactpersoon: {{ $task->client->contact_person_name }}</li>
        <li class="list-group-item">Contactpersoon Telefoonnummer: {{ $task->client->contact_person_phone_number }}</li>
        <li class="list-group-item">Factuur e-mailadres: {{ $task->client->invoice_email_address }}</li>

        <!-- Client details -->
        <li class="list-group-item">Opdrachtgever naam: {{ $task->client->user->name }}</li>
        <li class="list-group-item">E-mail van opdrachtgever: {{ $task->client->user->email }}</li>
        <li class="list-group-item">Telefoonnummer van opdrachtgever: {{ $task->client->user->phone_number }}</li>
        <h2 class="mt-5">Gebruikers die deelnemen aan deze opdracht:</h2>
        <div class="row">
            @foreach($task->userTasks()->where('admit', true)->where('status', 'geaccepteerd')->get() as $userTask)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $userTask->user->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $userTask->user->email }}</h6>
                        <p class="card-text">Telefoonnummer: {{ $userTask->user->phone_number }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </ul>
</div>
@endsection