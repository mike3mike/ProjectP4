@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Alle opdrachten</h1>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="input-group mb-3">
        <input id="taskSearch" type="text" class="form-control" placeholder="Zoeken naar opdrachten">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <div class="card-body table-responsive p-0">

        <table id="taskTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opdracht naam</th>
                    <th>Speeladres</th>
                    <th>Gevulde plekken</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Opties</th>
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
                    <td>{{ $task->status == "inBehandeling" ? "in behandeling" : $task->status }}</td>
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
                            <a href="{{ route('task.download', $task->id) }}" class="btn btn-success">Download speelformulier</a>

                            @else
                            <p class="text-danger">Fout</p>
                            @endif
                    </td>
                    <td>
                        @if ($task->status === 'inBehandeling')
                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"  onclick="confirmDeletion(event, this.parentElement);">Verwijderen</button>
                            </form>
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
</div>
@section('scripts')
<script>
    window.onload = function() {
        document.getElementById('taskSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.getElementById('taskTable').getElementsByTagName('tbody')[0].rows;

            for (let i = 0; i < tableRows.length; i++) {
                let columns = tableRows[i].getElementsByTagName('td');
                let rowText = '';

                for (let j = 0; j < columns.length; j++) {
                    rowText += columns[j].textContent.toLowerCase() + ' ';
                }

                tableRows[i].style.display = rowText.includes(searchValue) ? '' : 'none';
            }
        });
    };
</script>

@endsection
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeletion(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Weet je het zeker?',
            text: "Je zult deze actie niet kunnen terugdraaien!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, verwijder het!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }
    </script>    
@endsection