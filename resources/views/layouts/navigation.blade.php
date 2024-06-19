<ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
    @if (Auth::user()->hasRole('admin'))
        <li>
            <a href="{{route('dashboard')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-house"></i>
                </span>
                Home
            </a>
        </li>
        <li>
            <a href="{{route('admin-periods')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-calendar-event"></i>
                </span>
                Periods
            </a>
        </li>
        <li>
            <a href="{{route('admin-complaints')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-chat"></i>
                </span>
                Complaints
            </a>
        </li>
        <li>
            <a href="{{route('admin-tasks')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-pencil-square"></i>
                </span>
                Tasks
            </a>
        </li>
        <li>
            <a href="{{route('admin-permits')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-file-earmark-medical"></i>
                </span>
                Permits
            </a>
        </li>
    @elseif (Auth::user()->hasRole('officer'))
        <li>
            <a href="{{route('officer-dashboard')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-pencil-square"></i>
                </span>
                Tasks
            </a>
        </li>
    @else
        <li>
            <a href="{{route('dashboard')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-house"></i>
                </span>
                Home
            </a>
        </li>
        <li>
            <a href="{{route('user-complaints')}}" class="nav-link text-white">
                <span class="bi d-block mx-auto mb-1" width="24" height="24">
                    <i class="bi bi-chat"></i>
                </span>
                Complaints
            </a>
        </li>
    @endif
    <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset('images/user.png')}}" height="45" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
                <h6>{{Auth::user()->name}}</h6>
                <span>{{ Auth::user()->roles->first()->display_name }}</span>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class="bi bi-question-circle"></i>
                    <span>Need Help?</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
