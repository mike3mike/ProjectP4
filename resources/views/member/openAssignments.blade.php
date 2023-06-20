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
                <th>Opdrachtnummer</th>
                <th>status</th>
                <th>Toelaten</th>
                <th>Acties</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userTasks as $userTask)
            @if($userTask->admit ===null AND $userTask->status === null)
            <tr>
                <td>{{ $userTask->task_id }}</td>
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
                    @if($userTask->admit !== 1)
                    <form action="{{ route('member.openAssignments.accept', $userTask) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Accepteren</button>
                    </form>
                    <form action="{{ route('member.openAssignments.maybe', $userTask) }}" method="post" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-warning">Misschien</button>
                    </form>
                    <form action="{{ route('member.openAssignments.decline', $userTask) }}" method="post" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">Weigeren</button>
                    </form>
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