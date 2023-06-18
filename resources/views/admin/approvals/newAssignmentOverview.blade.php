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
                    <th>Opdracht Naam</th>
                    <th>Speeladres</th>
                    <th>Gevulde Plekken</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    @php
                        $filledSeats = $task->userTasks()->where('admit', true)->where('status', 'geaccepteerd')->count();
                    @endphp
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->playAddress->street_name}}, {{ $task->playAddress->city }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->house_number }}</td>
                        <td>{{ $filledSeats }} / {{ $task->max_users }}</td>
                        <td>{{ $task->date }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            @if ($task->status === 'inBehandeling')
                                <form action="{{ route('admin.approvals.approveAssignment', $task) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Accepteren</button>
                                </form>
                            @elseif ($task->status === 'lopend' && $filledSeats < $task->max_users)
                                <form action="{{ route('admin.invite', $task) }}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Leden uitnodigen</button>
                                </form>
                            @elseif ($task->status === 'lopend' && $filledSeats == $task->max_users)
                                <form action="{{ route('admin.finishTask', $task) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Opdracht Afronden</button>
                                </form>
                            @elseif ($task->status === 'afgerond')
                                {{-- <p class="text-success">Afgerond</p> --}}
                                <a href="{{ route('task.download', $task->id) }}" class="btn btn-success">Download Speelformulier</a>

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

{{-- @extends('layouts.app')

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
                    <th>Opdracht Naam</th>
                    <th>Speeladres</th>
                    <th>Gevulde Plekken</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->playAddress->street_name}}, {{ $task->playAddress->city }}, {{ $task->playAddress->postal_code }}, {{ $task->playAddress->house_number }}</td>
                        <td>{{ $task->userTasks()->where('admit', true)->where('status', 'geaccepteerd')->count()}} / {{$task-> max_users}}</td>
                        <td>{{ $task->date }}</td>
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
@endsection --}}

{{-- @extends('layouts.app')

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
                    <th>Opdracht Naam</th>
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
 --}}
