@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Gebruikers Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">
                <strong>Email:</strong> {{ $user->email }} <br>
                <strong>Telefoon Nummer:</strong> {{ $user->phone_number }} <br>
                <strong>Rollen:</strong>{{ $user->roles->pluck('name')->join(', ') }} <br>
                <strong>Aantal deelnemen :</strong> {{ $user->userTasks()->where('admit', true)->count() }} <br> 
                @if($user->hasRole('opdrachtgever'))
                    <strong>Bedrijfsnaam:</strong> {{ $user->client->company_name }} <br>
                    <strong>Contactpersoon:</strong> {{ $user->client->contact_person_name }} <br>
                    <strong>Contactpersoon Telefoonnummer:</strong> {{ $user->client->contact_person_phone_number }} <br>
                    <strong>Factuur Emailadres:</strong> {{ $user->client->invoice_email_address }} <br>
                    <strong>Factuur Adres:</strong> {{ $user->client->address->street_name }}, {{ $user->client->address->house_number }}, {{ $user->client->address->postal_code }}, {{ $user->client->address->city }}
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
