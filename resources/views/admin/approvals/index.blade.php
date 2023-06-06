@extends('layouts.app')

@section('content')
    <h1>Aanvragen</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form action="{{ route('admin.approvals.approve', $user) }}" method="post">
                            @csrf
                            <button type="submit">Goedkeuren</button>
                        </form>
                        <form action="{{ route('admin.approvals.delete', $user) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Verwijderen</button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

