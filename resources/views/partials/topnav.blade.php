<nav class="topnav">
    <a class="topnav-logo" href="#">
        <div class="topnav-logo-icon"><i class="ti ti-device-desktop"></i></div>
        CS Society
    </a>

    <div class="topnav-spacer"></div>

    <div class="topnav-avatar">
        {{ auth()->user()->initials ?? 'U' }}
    </div>
</nav>