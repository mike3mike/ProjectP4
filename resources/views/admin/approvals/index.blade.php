@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Aanvragen</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('admin.approvals.approve', $user) }}" method="post" class="mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Goedkeuren</button>
                                </form>
                                <form action="{{ route('admin.approvals.delete', $user) }}" method="post" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Verwijderen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Er zijn momenteel geen aanvragen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

