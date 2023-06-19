@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Leden uitnodigen voor taak nummer: {{ $task->id }}</h1>

        <form action="{{ route('admin.sendInvitation', $task) }}" method="post" id="userForm">
            @csrf
            <div class="input-group mb-3">
                <input id="taskSearch" type="text" class="form-control" placeholder="Zoeken naar leden">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Alles selecteren
                </label>
            </div>
            @foreach ($users as $user)
            <div id="userCard-{{ $user->id }}" class="card mb-3" style="width: 24rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted" style="font-size: 0.8rem;">{{ $user->email }}</h6>
                    <p class="card-text">Telefoonnummer: {{ $user->phone_number }}</p>
                    <p class="card-text">Aantal deelnemen : {{ $user->userTasks()->where('admit', true)->count() }} keer</p>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            selecteer lid
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary mt-3">Uitnodigingen versturen</button>
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
@section('scripts')
<script>
    window.onload = function() {
        document.getElementById('selectAll').addEventListener('change', function (event) {
            let form = document.getElementById('userForm');
            let checkboxes = form.querySelectorAll('input[type="checkbox"]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = event.target.checked;
            }
        });

        document.getElementById('taskSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let cards = document.querySelectorAll('.card');

            for (let i = 0; i < cards.length; i++) {
                let cardText = cards[i].textContent.toLowerCase();

                cards[i].style.display = cardText.includes(searchValue) ? '' : 'none';
            }
        });
    };
</script>
@endsection
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
