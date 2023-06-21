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

    <div class="card-body table-responsive p-0">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Status</th>
                    <th>Telefoonnummer</th>
                    <th>Rollen</th>
                    <th>Opties</th>
                    <th>Details</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)


                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>
                        {{ $user->roles->pluck('name')->join(', ') }}
                    </td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="confirmDeletion(event, this.parentElement);">Verwijderen</button>
                        </form>

                    </td>
                    <td><a href="{{ route('admin.users.show', $user) }}" class="btn btn-success">Details</a></td>


                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
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