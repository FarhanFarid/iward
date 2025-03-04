<div class="d-flex align-items-center justify-content-between w-100">
    <!-- IJN Flagship Logo (Far Left) -->
    <div class="me-auto">
        <img alt="Logo" src="{{ asset('media/logo/ijnflagship.png') }}" 
             style="max-height: 50px; margin-bottom: 5px;">
    </div>

    <!-- User Profile (Far Right) -->
    <div class="dropdown ms-auto">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2"><b>Hi, {{ Auth::user()->usersso->name }}</b></span>
            <img src="{{ Auth::user()->usersso->photo }}" alt="User" class="rounded-3" width="40" height="40">
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow p-3" aria-labelledby="userDropdown" style="width: 300px; padding: 20px;">
            <li class="d-flex align-items-center px-3">
                <img src="{{ Auth::user()->usersso->photo }}" 
                     alt="User" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <strong>{{ Auth::user()->usersso->name }}</strong><br>
                    <small class="text-muted">{{ Auth::user()->usersso->email }}</small><br>
                    <small class="text-muted">{{ Auth::user()->usersso->department }}</small>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li class="text-center"> <!-- Add text-center class to center the button -->
                <a class="btn btn-danger btn-sm" href="{{ route('sso.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   style="width: 250px !important;">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('sso.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            
        </ul>
    </div>
</div>
