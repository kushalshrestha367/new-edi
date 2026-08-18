<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHeader" aria-labelledby="offcanvasHeaderLabel">
    <div class="offcanvas-header">
        <a href="{{ route('welcome') }}" class="logo">
            @if ($blog_setting && $blog_setting->logo)
                <img src="{{ Storage::url($blog_setting->logo) }}" class="img-fluid w-50" alt="Logo" />
            @endif
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column gap-4">
            <ul class="navbar-nav">
                @include('web.layouts.nav')
            </ul>
            <div class="d-flex flex-column">
                <a href="#" class="btn btn-dark px-4 py-2 w-100 justify-content-center">Contact</a>
            </div>

            <ul class="list-unstyled mb-0 d-flex flex-row justify-content-between align-items-center gap-3 px-2">
                <li><a class="text-decoration-none" href="#">QAA</a></li>
                <li class="text-secondary text-success">•</li>
                <li><a class="text-decoration-none" href="#">EMIS</a></li>
                <li class="text-secondary text-success">•</li>
                <li><a class="text-decoration-none" href="#">Journal</a></li>
                <li class="text-secondary text-success">•</li>
                <li><a class="text-decoration-none" href="{{ route('career') }}">Career</a></li>
            </ul>

        </div>
    </div>
</div>

