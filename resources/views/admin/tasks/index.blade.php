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
    <h1 class="my-3">Beheer van opdrachten</h1>
    <div class="input-group mb-3">
        <input id="taskSearch" type="text" class="form-control" placeholder="Zoeken naar opdrachten">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <table id="taskTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Taak Naam</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Gevulde Plekken</th>
                <th>Aanmeldingen</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->date }}</td>
                        <td>{{ $task->status == "inBehandeling" ? "in behandeling" : $task->status }}</td>
                        <td>{{ $taskAdmits[$task->id] }}/{{ $task->max_users }}</td>
                        <td>{{ $task->userTasks->where('admit', 0)->count() }}</td>
                        <td>
                            {{-- {{ dump($task) }} --}}
                            <form action="{{ route('admin.tasks.showTask', $task) }}" method="get" class="mt-2">
                                <button type="submit" class="btn btn-info">Bekijken</button>
                            </form>
                        </td>
                    </tr>
       
            @endforeach
        </tbody>
    </table>
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
@endsection
