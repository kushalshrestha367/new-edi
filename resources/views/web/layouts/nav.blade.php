<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle py-2 px-3 rounded-pill fw-medium {{ request()->is('about/*') ? 'active' : '' }}"
        href="#programs" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        About Us
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('about') }}">Introduction</a>
        </li>
        @foreach ($site_team as $team_menu)
            <li>
                <a class="dropdown-item" href="{{ route('team.detail', $team_menu->slug) }}">
                    Message from
                    {{ $team_menu->designation }}
                </a>
            </li>
        @endforeach
        <li>
            <a class="dropdown-item" href="{{ route('team') }}">
                Our Team
            </a>
        </li>
    </ul>
</li>

{{-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle py-2 px-3 rounded-pill fw-medium" href="#programs"
        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Programs
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="#">BHM</a></li>
        <li><a class="dropdown-item" href="#">BBA</a></li>
        <li><a class="dropdown-item" href="#">MBA</a></li>
    </ul>
</li> --}}
<li class="nav-item">
    <a class="nav-link py-2 px-3 rounded-pill fw-medium {{ request()->is('program') ? 'active' : '' }}"
        href="{{ route('program') }}">Programs</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle py-2 px-3 rounded-pill fw-medium {{ request()->is('gallery/*') ? 'active' : '' }}"
        href="#programs" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Gallery
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a href="{{ route('gallery') }}" class="dropdown-item">Image</a></li>
        <li><a href="{{ route('gallery.video') }}" class="dropdown-item">Video</a></li>
        @if (false)
            <li>
                <a href="{{ route('filamentblog.post.index') }}" class="dropdown-item">Blog</a>
            </li>
        @endif
    </ul>
</li>
@if ($site_service_items->isNotEmpty())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle py-2 px-3 rounded-pill fw-medium {{ request()->is('facilities/*') ? 'active' : '' }}"
            href="#programs" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Facilities
        </a>

        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($site_service_items as $sitem)
                <li><a class="dropdown-item"
                        href="{{ route('service.item.detail', $sitem->slug) }}">{{ $sitem->title }}</a>
                </li>
            @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link py-2 px-3 rounded-pill fw-medium" href="{{ route('service') }}">Facilities</a>
    </li>
@endif
{{-- <li class="nav-item">
    <a class="nav-link py-2 px-3 rounded-pill fw-medium {{ request()->is('team') ? 'active' : '' }}"
        href="{{ route('team') }}">
        Our Team
    </a>
</li> --}}
@if ($download_items->isNotEmpty())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle py-2 px-3 rounded-pill fw-medium {{ request()->is('downloads/*') ? 'active' : '' }}"
            href="#programs" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Downloads
        </a>

        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($download_items as $ditem)
                <li><a href="{{ route('download.item.detail', $ditem->slug) }}"
                        class="dropdown-item">{{ $ditem->title }}</a></li>
            @endforeach
        </ul>
    </li>
@endif
{{-- @if ($department_isEmpty)
    <li class="nav-item">
        <a href="{{ route('department') }}" class="nav-link py-2 px-3 rounded-pill fw-medium">Department</a>
    </li>
@endif --}}
@if (false)
    <li class="nav-item">
        <a href="{{ route('news-and-event') }}" class="nav-link py-2 px-3 rounded-pill fw-medium">News & Event</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('career') }}" class="nav-link py-2 px-3 rounded-pill fw-medium">Career</a>
    </li>
@endif
