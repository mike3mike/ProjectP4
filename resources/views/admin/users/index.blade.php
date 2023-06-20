@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">gebruikers</h1>
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
                <th>naam</th>
                <th>status</th>
                <th>telefoon nummer</th>
                <th>rollen</th>
                <th>acties</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
             @if ($user->hasApprovedRole()) <!-- alleen gebruikers die al een rol hebben -->

            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>0{{ $user->phone_number }}</td>
                <td></td> 
                <td><form action="{{ route('admin.users.index.delete', $user) }}" method="post">
                        <button type="submit" class="btn btn-success">verwijderen</button>
                                                @csrf

                    </form></td>



            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection