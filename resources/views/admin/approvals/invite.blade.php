@extends('layouts.app')

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
@endsection
