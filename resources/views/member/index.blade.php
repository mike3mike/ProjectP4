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
        {{-- <a href="{{ route('task.submit_become_client') }}" class="btn btn-primary">Nieuwe Opdracht</a> --}}
    </div>
    <div class="card-body table-responsive p-0">

        <table class="table">
            <thead>
                <tr>
                    <th>Opdracht naam</th>
                    <th>Opdrachtnummer</th>
                    <th>Speeladres</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Opties</th>

                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_id }}</td>
                    <td>{{ $task->playAddress->street_name}}, {{ $task->playAddress->city }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->house_number }}</td>
                    <td>{{ $task->date}}</td>
                    <td>{{ $task->status }}</td>

                    <td>
                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-info">Bekijk details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection