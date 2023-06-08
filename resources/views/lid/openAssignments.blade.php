@extends('layouts.app')

@section('content')
    <h1>Uitnodigingen</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>info1</th>
                <th>info2</th>
                <th>info3</th>
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
                            <button type="submit">Accepteren</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('member.openAssignments.maybe', $userTask) }}" method="post">
                            @csrf
                            <button type="submit">Ik weet het nog niet</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('member.openAssignments.decline', $userTask) }}" method="post">
                            @csrf
                            <button type="submit">Weigeren</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection