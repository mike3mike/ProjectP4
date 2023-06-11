@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Invite Members to Task {{ $task->id }}</h1>

        <form action="{{ route('admin.sendInvitation', $task) }}" method="post" id="userForm">
            @csrf
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Select All
                </label>
            </div>
            @foreach ($users as $user)
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
                        <p class="card-text">Phone Number: {{ $user->phone_number }}</p>
                        <p class="card-text">Admitted: {{ $user->userTasks()->where('admit', true)->count() }} times</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Select User
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Send Invitations</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    // console.log('Script is running');

    window.onload = function() {
        document.getElementById('selectAll').addEventListener('change', function (event) {
            let form = document.getElementById('userForm');
            let checkboxes = form.querySelectorAll('input[type="checkbox"]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = event.target.checked;
            }
        });
    };
</script>
@endsection




{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Invite Members to Task {{ $task->id }}</h1>

        <form action="{{ route('admin.sendInvitation', $task) }}" method="post">
            @csrf

            @foreach ($users as $user)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        {{ $user->name }}
                    </label>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Send Invitations</button>
        </form>
    </div>
@endsection --}}
