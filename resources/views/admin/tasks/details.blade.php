@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Details</h2>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Gebruiker naam</dt>
                <dd class="col-sm-9">{{ $userTask->user->name }}</dd>

                <dt class="col-sm-3">Gebruiker e-mail</dt>
                <dd class="col-sm-9">{{ $userTask->user->email }}</dd>

                <dt class="col-sm-3">Gebruiker rol</dt>
                <dd class="col-sm-9">{{ $userTask->user->roles->pluck('name')->join(', ') }}</dd>

                <dt class="col-sm-3">Taak naam</dt>
                <dd class="col-sm-9">{{ $userTask->task->task_name }}</dd>

                <dt class="col-sm-3">Datum</dt>
                <dd class="col-sm-9">{{ $userTask->task->date }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ $userTask->status }}</dd>

                <dt class="col-sm-3">Toelaten</dt>
                <dd class="col-sm-9">{{ $userTask->admit ? 'Goedgekeurd' : 'Nog niet goedgekeurd' }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection