@extends('layouts.app')
@section('navItems')
<li class="nav-item menu-open">
    <a href="#" class="nav-link ">
        <p>
            leden
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="./index.html" class="nav-link ">
                <p>beheren</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./index2.html" class="nav-link">
                <p>toevoegen</p>
            </a>
        </li>

    </ul>
</li>
<li class="nav-item menu-open">
    <a href="/admin/tasks" class="nav-link ">
        <p>
            opdrachten
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
  
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/admin/tasks" class="nav-link ">
                <p>beheren</p>
            </a>
        </li>

    </ul>
</li>
<li class="nav-item menu-open">
    <a href="/admin/approvals/" class="nav-link ">
        <p>
            bevestigingen
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/admin/approvals/" class="nav-link ">
                <p>beheren</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/approvals/newAssignment" class="nav-link">
                <p>toevoegen</p>
            </a>
        </li>


    </ul>
</li>
<li class="nav-item menu-open">
    <a href="/role-requests/" class="nav-link ">
        <p>
            toegang
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/role-requests/" class="nav-link ">
                <p>rol aanvragen</p>
            </a>
        </li>



    </ul>


</li>
@endsection