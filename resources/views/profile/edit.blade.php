@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Uw profiel</h2>
    @if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="form-group">
        <label for="name">Naam:</label>
        <span>{{ $user->name }}</span>
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <span>{{ $user->email }}</span>
    </div>
    <div class="form-group">
        <label for="phone_number">Telefoonnummer :</label>
        <span>{{ $user->phone_number }}</span>
    </div>
    <div class="form-group">
        <label for="role">Rollen:</label>
        <ul>
            @if($user->hasRole('lid'))
            @if($user->is_approved_member)
            <li>Lid</li>
            @else
            <li>Lid (In behandeling)</li>
            @endif
            @endif
            @if($user->hasRole('opdrachtgever'))
            @if($user->is_approved_client)
            <li>Opdrachtgever</li>
            @else
            <li>Opdrachtgever (In behandeling)</li>
            @endif
            @endif
            @if($user->hasRole('coordinator'))
            @if($user->is_approved_coordinator)
            <li>Coördinator</li>
            @else
            <li>Coördinator (In behandeling)</li>
            @endif
            @endif
        </ul>
    </div>


    <div class="form-group">
        <label for="aantal_deelnemen">Aantal deelnemen :</label>
        <span>{{ $user->userTasks()->where('admit', true)->count() }}</span>
    </div>

    @if($user->hasRole('opdrachtgever'))
    <div class="form-group">
        <strong>Bedrijfsnaam:</strong> {{ $user->client->company_name }} <br>
        <strong>Contactpersoon:</strong> {{ $user->client->contact_person_name }} <br>
        <strong>Contactpersoon telefoonnummer:</strong> {{ $user->client->contact_person_phone_number }} <br>
        <strong>Factuur e-mailadres:</strong> {{ $user->client->invoice_email_address }} <br>
        <strong>Factuur adres:</strong> {{ $user->client->address->street_name }}, {{ $user->client->address->house_number }}, {{ $user->client->address->postal_code }}, {{ $user->client->address->city }}
    </div>
    @endif

    @if(!$user->hasRole('lid'))
    <div class="form-group">
        <a href="{{ route('becomeMember',$user->id) }}" class="btn btn-primary">LOTUS lid worden</a>
    </div>
    @endif
    @if(!$user->hasRole('opdrachtgever'))
    <div class="form-group">
        <form method="get" action="{{ route('become_client_form') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Opdrachtgever worden</button>
        </form>
    </div>
    @endif
    @if(!$user->hasRole('coordinator'))
    <div class="form-group">
        <a href="{{ route('becomeCoordinator',$user->id) }}" class="btn btn-primary">Coördinator worden</a>
    </div>
    @endif
</div>
@endsection