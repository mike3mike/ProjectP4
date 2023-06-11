@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Uitnodigingen</h1>
        <a href="{{ route('member.check_client_status') }}" class="btn btn-primary">Nieuwe Opdracht</a>
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
                    <th>taskId</th>
                    <th>status</th>
                    <th>admit</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userTasks as $userTask)
                    <tr>
                        <td>{{ $userTask->id }}</td>
                        <td>{{ $userTask->status }}</td>
                        <td>{{ $userTask->admit }}</td>
                        <td>
                            <form action="{{ route('member.openAssignments.accept', $userTask) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Accepteren</button>
                            </form>
                            <form action="{{ route('member.openAssignments.maybe', $userTask) }}" method="post" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-warning">Ik weet het nog niet</button>
                            </form>
                            <form action="{{ route('member.openAssignments.decline', $userTask) }}" method="post" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-danger">Weigeren</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
