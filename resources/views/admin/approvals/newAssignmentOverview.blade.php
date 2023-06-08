@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Aangevraagde opdrachten</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>info1</th>
                    <th>info2</th>
                    <th>info3</th>
                    <th>Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            @if ($task->status === 'inBehandeling')
                                <form action="{{ route('admin.approvals.approveAssignment', $task) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Accepteren</button>
                                </form>
                            @elseif ($task->status === 'lopend')
                                <form action="{{ route('admin.invite', $task) }}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Leden uitnodigen</button>
                                </form>
                            @elseif ($task->status === 'afgerond')
                                <p class="text-success">Afgerond</p>
                            @else
                                <p class="text-danger">Fout</p>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('task.show_task_details_admin', $task->id) }}" class="btn btn-info">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

