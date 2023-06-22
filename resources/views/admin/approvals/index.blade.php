@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-3">Aangevraagde accounts</h1>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @foreach (['members' => 'Leden', 'clients' => 'Opdrachtgevers', 'coordinators' => 'Coördinatoren'] as $role => $label)
    <h2>{{ $label }}</h2>
    <div class="card-body table-responsive p-0">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mail</th>
                    <th>Rol</th>
                    <th>Opties</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($$role as $user)
                @if ($user->isRoleApprovalFirstTime()) <!-- alleen gebruikers die voor het eerst een rol aanvragen -->
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>

                    <td>
                        <div class="d-flex">
                            <form action="{{ route('admin.approvals.approve'.ucfirst($role), $user) }}" method="post" class="mr-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Goedkeuren</button>
                            </form>
                            <form action="{{ route('admin.approvals.delete', $user) }}" method="post" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmDeletion(event, this.parentElement);">Verwijderen</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="3">Er zijn momenteel geen aanvragen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endforeach
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
@endsection