@extends('layouts.app')
@section('navItems')
<li class="nav-item menu-open">
    <a class="nav-link ">
        <p>

            opdrachten
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/client" class="nav-link">
                <p>overzicht</p>
            </a>
        </li>



    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/client/create" class="nav-link">
                <p>aanmaken</p>
            </a>
        </li>



    </ul>
</li>

@endsection