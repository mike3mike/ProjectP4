@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Rol aanvragen</h1>
        @if (session('success')) 
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="list-group">
            @foreach ($users as $user)
            @if ($user->hasApprovedRole()) <!-- alleen gebruikers die al een rol hebben -->
                <div class="list-group-item">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p>Heeft een aanvraag ingediend om de volgende rollen te worden:</p>
                    
                    @foreach($user->roles as $role)
                    
                    <?php $approvalAttribute = $user->getApprovalAttributeForRole($role->name); ?>
                    @if(!$user->$approvalAttribute)
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $role->name }}</span>

                                <form class="d-inline-block" action="{{ route('admin.role-requests.approve', [$user, $role]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success" type="submit">Goedkeuren</button>
                                </form>
                                <form class="d-inline-block" action="{{ route('admin.role-requests.deny', [$user, $role]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Weigeren</button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Rol aanvragen</h1>
        @if (session('success')) 
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="list-group">
            @foreach ($users as $user)
                <div class="list-group-item">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p>Heeft een aanvraag ingediend om de volgende rollen te worden:</p>
                    
                    @foreach(['member', 'coordinator', 'client'] as $role)
                        @if(!$user->{"is_approved_$role"})
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $role }}</span>

                                <form class="d-inline-block" action="{{ route('admin.role-requests.approve', [$user, $role]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success" type="submit">Goedkeuren</button>
                                </form>
                                <form class="d-inline-block" action="{{ route('admin.role-requests.deny', [$user, $role]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Weigeren</button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
 --}}
