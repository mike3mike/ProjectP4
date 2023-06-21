@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Geaccepteerde opdrachten</h1>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Opdrachtnummer</th>
                <th>Opdracht naam</th>
                <th>Speeladres</th>
                <th>Datum</th>
                <th>status</th>
                <th>Toelaten</th>
                <th>Opties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userTasks as $userTask)
            @if($userTask->admit === 1)

            <tr>
                <td>{{ $userTask->task_id }}</td>
                <td>{{ $userTask->task->task_name}}</td>
                <td>{{$userTask->task->playAddress->street_name}}, {{ $userTask->task->playAddress->city }}, {{ $userTask->task->playAddress->postal_code }}, {{$userTask->task->playAddress->house_number }}</td>                <td>{{ $userTask->task->date}}</td>
                <td> @if($userTask->status === null)
                    Nog niet beslist
                    @elseif($userTask->status !== null)
                    {{$userTask->status}}
                    @endif
                </td>

                <td>
                    @if($userTask->admit === null)
                    Nog niet bekend
                    @elseif($userTask->admit == 0)
                    Niet Goedgekeurd
                    @elseif($userTask->admit == 1)
                    Goedgekeurd
                    @endif
                </td>
                <td>
                    <a href="{{ route('task.showMember', $userTask->task_id) }}" class="btn btn-info">Details</a>
                </td>

            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection