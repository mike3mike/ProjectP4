@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success')) 
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error')) 
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif
    <div class="input-group mb-3">
        <input id="taskSearch" type="text" class="form-control" placeholder="Zoeken naar leden">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <table  id="taskTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Gebruiker</th>
                <th>Status</th>
                <th>Toelaten</th>
                <th>Gevulde Plekken</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{ dump($task->userTasks) }} --}}
                @foreach ($task->userTasks as $userTask)
                {{-- {{ dump($userTask) }} --}}
                @if($userTask->admit ===null)
                    <tr>
                        <td>{{ $userTask->user->name }} - {{ $userTask->user->email }}</td>
                        <td> @if($userTask->status === null)
                            Nog niet beslist
                        @elseif($userTask->status !== null)
                        {{$userTask->status}}
                        @endif</td>
                        <td>{{ $userTask->admit ? 'Goedgekeurd' : 'Nog Niet Goedgekeurd' }}</td>
                        <td>{{ $taskAdmits}}/{{ $task->max_users }}</td>
                        <td>
                            @if($task->status !== 'afgerond')
                            <form action="{{ route('admin.tasks.approve', $userTask) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Goedkeuren</button>
                            </form>
                            <form action="{{ route('admin.tasks.remove', $userTask) }}" method="post" class="mt-2" >
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="confirmDeletion(event, this.parentElement);">Verwijderen</button>
                            </form>
                            @else
                    <p>De opdracht is al afgerond</p>
                @endif
                            <form action="{{ route('admin.tasks.details', $userTask) }}" method="get" class="mt-2">
                                <button type="submit" class="btn btn-info">Details</button>
                            </form>
                        </td>
                    </tr>
                    @endif
            @endforeach
        </tbody>
    </table>
</div>
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
@endsection
{{-- onsubmit="return confirm('Weet je zeker dat je deze gebruikerstaak wilt verwijderen?');" --}}