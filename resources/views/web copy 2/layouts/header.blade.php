<header class="header position-fixed start-0 top-0 w-100">
    <div class="container">
        <nav class="navbar navbar-expand-xl rounded-pill p-7">
            <div class="d-flex align-items-center justify-content-between w-100">
                <a href="{{ route('welcome') }}" class="logo">
                    @if ($blog_setting && $blog_setting->logo)
                        <img src="{{ Storage::url($blog_setting->logo) }}" class="img-fluid logo-img"
                            alt="{{ $blog_setting->title }}" />
                    @endif
                </a>
                <button class="navbar-toggler border-0 p-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasHeader" aria-controls="offcanvasHeader">
                    <iconify-icon icon="solar:hamburger-menu-linear" class="fs-8 text-dark"></iconify-icon>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto gap-2 p-1 bg-light rounded-pill">
                        @include('web.layouts.nav')
                        
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link py-2 px-3 rounded-pill fw-medium searchToggle" id="searchToggle">
                                <i class="fa-solid fa-search"></i>
                            </a>
                        </li>
                    </ul>
                    <form action="{{ route('search.all') }}" method="GET" id="searchForm"
                        class="d-none ms-3 position-absolute position-area">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control shadow-0" placeholder="Search..."
                                required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('contact') }}" class="btn btn-dark px-4 py-2">Contact</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

@include('web.layouts.header-sm')

