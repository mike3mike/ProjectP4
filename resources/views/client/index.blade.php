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
        <a href="{{ route('task.create') }}" class="btn btn-primary">Nieuwe opdracht</a>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Opdrachtvnaam</th>
                    <th>Opdrachtnummer</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Opties</th>

                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->date }}</td>
                    <td>{{ $task->status == "inBehandeling" ? "in behandeling" : $task->status }}</td>

                    <td>
                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-info">Bekijk details</a>
                        @if($task->status == 'afgerond')
                        <!-- Als dat zo is, tonen we de downloadknop. -->
                        <a href="{{ route('task.download', $task->id) }}" class="btn btn-success">Download speelformulier</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection