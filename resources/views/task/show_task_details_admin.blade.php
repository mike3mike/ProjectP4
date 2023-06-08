@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Details van Opdracht {{ $task->id }}</h1>
    <ul class="list-group">
        <li class="list-group-item">Opdrachtnaam: {{ $task->task_name }}</li>
        <li class="list-group-item">Opdrachtnummer: {{ $task->task_number }}</li>
        <li class="list-group-item">Soort Opdracht: {{ $task->task_type }}</li>
        <li class="list-group-item">Speellocatie Adres: {{ $task->playAddress->street_name }} {{ $task->playAddress->house_number }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->city }}</li>
        <li class="list-group-item">Griemlocatie Adres: {{ $task->makeupAddress->street_name }} {{ $task->makeupAddress->house_number }}, {{ $task->makeupAddress->postal_code }}, {{ $task->makeupAddress->city }}</li>
        <li class="list-group-item">Bedrijfsnaam: {{ $task->client->company_name }}</li>
        <li class="list-group-item">Contactpersoon: {{ $task->client->contact_person_name }}</li>
        <li class="list-group-item">Contactpersoon Telefoonnummer: {{ $task->client->contact_person_phone_number }}</li>
        <li class="list-group-item">Factuur E-mailadres: {{ $task->client->invoice_email_address }}</li>
        
        <!-- User details -->
        <li class="list-group-item">Gebruikersnaam: {{ $task->client->user->name }}</li>
        <li class="list-group-item">E-mail van opdrachtgever: {{ $task->client->user->email }}</li>
        <li class="list-group-item">Telefoonnummer van opdrachtgever: {{ $task->client->user->phone_number }}</li>
        
    </ul>
</div>
@endsection
