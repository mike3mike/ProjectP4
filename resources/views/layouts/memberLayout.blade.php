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
            <a href="/member/open-assignments" class="nav-link">
                <p>uitnodigingen</p>
            </a>
        </li>



    </ul>
</li>

@endsection