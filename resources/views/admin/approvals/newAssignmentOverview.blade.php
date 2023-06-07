@extends('layouts.app')

@section('content')
    <h1>Aangevraagde opdrachten</h1>

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
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <form action="{{ route('admin.approvals.approveAssignment', $task) }}" method="post">
                            @csrf
                            <button type="submit">Goedkeuren</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection