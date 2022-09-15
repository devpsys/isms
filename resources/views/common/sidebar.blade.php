<!-- Sidebar Menu -->
@php $r = request(); @endphp
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('timetables') }}"
               class="nav-link @if($r->routeIs('timetables') || $r->routeIs('timetables.*')) active @endif">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                    Time Table
                </p>
            </a>
        </li>
        <li class="nav-item @if($r->routeIs('manage.*')) menu-open @endif">
            <a href="#" class="nav-link @if($r->routeIs('manage.*')) active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Administration
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('manage.sessions') }}"
                       class="nav-link @if($r->routeIs('manage.sessions')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sessions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.sections') }}"
                       class="nav-link @if($r->routeIs('manage.sections')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sections</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.classes') }}"
                       class="nav-link @if($r->routeIs('manage.classes')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Classes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.subjects') }}"
                       class="nav-link @if($r->routeIs('manage.subjects')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Subjects</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.teachers') }}"
                       class="nav-link @if($r->routeIs('manage.teachers')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Teachers</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
