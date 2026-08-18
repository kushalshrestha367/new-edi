<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (!empty($site_setting?->maintenance_mode) && $site_setting?->maintenance_mode == '1')
        {!! \Firefly\FilamentBlog\Facades\SEOMeta::generate() ?: config('app.name') !!}
    @else
        {!! seo()->for($seoModel) ?? seo() !!}

        @if ($blog_setting)
            {!! $blog_setting?->google_console_code !!}
            {!! $blog_setting?->google_adsense_code !!}
        @endif

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        @stack('css-top')

        <link rel="stylesheet" href="{{ asset('web/libs/aos-master/dist/aos.css') }}">
        <style>
            :root {
                --site-primary: {{ $site_setting->primary_color ?? '#ce9233' }} !important;
                --primary: {{ $site_setting->primary_color ?? '#ce9233' }} !important;
                --site-secondary: {{ $site_setting->secondary_color ?? '#797672' }} !important;
                --secondary: {{ $site_setting->secondary_color ?? '#797672' }} !important;
                --site-light: {{ $site_setting->light_color ?? '#F9F8F7' }};
                --site-dark: {{ $site_setting->dark_color ?? '#2B2C2E' }};
            }
        </style>
        <link rel="stylesheet" href="{{ asset('web/css/styles.css') }}" />
        <link rel="stylesheet" href="{{ asset('web/css/main.css') }}" />
        @stack('css')
        <link rel="stylesheet" href="{{ url('web/libs/toastr/toastr.min.css') }}">
    @endif
</head>

<body>
    @if (!empty($site_setting?->maintenance_mode) && $site_setting?->maintenance_mode == '1')
        <h2>Under Maintainace...</h2>
    @else
        @stack('loader')

        @include('web.layouts.header')

        <div class="page-wrapper overflow-hidden">
            @yield('content')
        </div>

        <!--  Footer -->
        <footer class="footer pt-md-11 pt-lg-12 pt-xl-13">
            <div class="container">
                <div class="py-11 py-5 py-lg-12 pb-0 pb-lg-12">
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-11 mb-lg-0">
                            <div class="d-flex flex-column gap-4 me-xl-5">
                                @if ($blog_setting && $blog_setting->logo)
                                    <a href="{{ route('welcome') }}" class="d-block">
                                        <img src="{{ Storage::url($blog_setting->logo) }}"
                                            alt="{{ $blog_setting->title }}" class="img-fluid">
                                    </a>
                                @endif

                                @if ($blog_setting && $blog_setting->description)
                                    <div class="no-b-space">
                                        {!! $blog_setting->description !!}
                                    </div>
                                @endif

                                @if ($site_contact && $site_contact->socialMedia->isNotEmpty())
                                    <div class="hstack gap-3 social-saffron">
                                        @foreach ($site_contact->socialMedia->sortBy('sort_order') as $social)
                                            <a href="{{ $social->link }}" class="btn-social"
                                                aria-label="{{ $social->icon_name }}" target="_blank"
                                                data-title="{!! $social->icon_name !!}">
                                                @if ($social->icon_name == 'other')
                                                    {!! $social->icon !!}
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>
                        @if (!empty($blog_quick_links))
                            <div class="col-md-4 col-lg mb-11 mb-lg-0">
                                <div class="d-flex flex-column gap-3">
                                    <h6 class="mb-0">Quick Links</h6>
                                    <ul class="footer-menu list-unstyled mb-0 d-flex flex-column gap-7">
                                        @foreach ($blog_quick_links as $link)
                                            <li><a class="link-hover text-body" href="{{ $link['url'] }}"
                                                    target="_blank"
                                                    title="{{ $link['label'] }}">{{ \Illuminate\Support\Str::limit($link['label'], 30, '...') }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4 col-lg-2 mb-11 mb-lg-0">
                            <div class="d-flex flex-column gap-3">
                                <h6 class="mb-0">Other Links</h6>
                                <ul class="footer-menu list-unstyled mb-0 d-flex flex-column gap-7">
                                    <li><a class="link-hover text-body" href="#">QAA</a></li>
                                    <li><a class="link-hover text-body" href="#">EMIS</a></li>
                                    <li><a class="link-hover text-body" href="#">Journal</a></li>
                                    <li><a class="link-hover text-body" href="{{ route('career') }}">Career</a></li>
                                </ul>
                            </div>
                        </div>

                        @if ($site_contact)
                            <div class="col-md-4 col-lg mb-11 mb-lg-0">
                                <div class="d-flex flex-column gap-3">
                                    <h6 class="mb-0">Contact Details</h6>

                                    <ul class="list-unstyled d-flex flex-column gap-3">
                                        @if ($site_contact->address)
                                            <li class="d-flex">
                                                <div style="width: 30px;">
                                                    <i class="fa-solid fa-location-dot text-primary"></i>
                                                </div>
                                                <span>
                                                    <a href="#" target="_blank" class="link-hover text-body">
                                                        {{ $site_contact->address }}
                                                    </a>
                                                </span>
                                            </li>
                                        @endif
                                        @if ($site_contact->email)
                                            <li class="d-flex align-items-center">
                                                <div style="width: 30px;">
                                                    <i class="fa-solid fa-envelope text-primary"></i>
                                                </div>
                                                <a href="mailto:info@sasthm.edu.np"
                                                    class="link-hover text-body">{{ $site_contact->email }}</a>
                                            </li>
                                        @endif
                                        @if ($site_contact->phone)
                                            <li class="d-flex align-items-center">
                                                <div style="width: 30px;">
                                                    <i class="fa-solid fa-phone text-primary"></i>
                                                </div>
                                                <a href="tel:{{ $site_contact->phone }}"
                                                    class="link-hover text-body">{{ $site_contact->phone }}</a>
                                            </li>
                                        @endif
                                        @if ($site_contact->fax)
                                            <li class="d-flex align-items-center">
                                                <div style="width: 30px;">
                                                    <i class="fa-solid fa-fax text-primary"></i>
                                                </div>
                                                <a class="link-hover text-body">{{ $site_contact->fax }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="py-2 pt-3 border-top">
                    <div class="container">
                        <div class="row align-items-center">

                            <div class="col-md-4 text-center text-md-start order-2 order-md-1">
                                <span class="text-sm">
                                    &copy; 2026
                                    {{ date('Y') != '2026' ? '- ' . date('Y') : '' }}
                                    {{ $blog_setting->title ?? config('app.name', 'Saffron Infosys Pvt. Ltd.') }},
                                    All rights reserved.
                                </span>
                            </div>

                            <div class="col-md-4 text-center order-1 order-md-2 mb-3 mb-md-0">
                                <img src="{{ asset('images/pu.png') }}" class="img-fluid" style="max-width: 50px;">
                                @if (@$affiliated_with)
                                    <small class="d-block" style="font-size:9px;">Affiliated with {{ $affiliated_with }}</small>
                                @endif
                            </div>

                            <div class="col-md-4 text-center text-md-end order-3">
                                <ul
                                    class="list-unstyled d-flex flex-wrap gap-2 mb-0 justify-content-center justify-content-md-end">
                                    <li><a href="{{ route('faqs') }}" class="link-hover text-body text-sm">FAQs</a>
                                    </li>
                                    <li class="text-secondary text-success">•</li>
                                    <li><a href="#" class="link-hover text-body text-sm">Privacy</a></li>
                                    <li class="text-secondary text-success">•</li>
                                    <li><a href="#" class="link-hover text-body text-sm">Terms</a></li>
                                    <li>
                                        | Developed by <a href="https://saffron.info.np" target="_blank"
                                            class="link-hover text-dark">Saffron
                                            Infosys</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </footer>

        {{-- apply  --}}
        <div class="scroller hstack gap-2">
            {{-- <a class="bg-primary px-3 py-2 rounded fs-3 fw-semibold text-white shine-effect"
                href="{{ route('appointment.create') }}">Apply
                Now</a> --}}
            <button class="btn bg-primary p-2 round-40 rounded hstack justify-content-center flex-shrink-0"
                id="scrollToTopBtn">
                <iconify-icon icon="solar:alt-arrow-up-linear" class="fs-7 text-white"></iconify-icon>
            </button>
        </div>

        <script src="{{ asset('web/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('web/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        @stack('js-top')

        <script src="{{ asset('web/libs/aos-master/dist/aos.js') }}"></script>
        <script src="{{ asset('web/js/custom.js') }}"></script>
        {{-- solar icons --}}
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

        @stack('js')
        @stack('js-down')
        <script>
            $(document).ready(function() {
                const socialIconMap = {
                    'facebook': 'fab fa-facebook-f',
                    'twitter': 'fab fa-x-twitter',
                    'linkedin': 'fab fa-linkedin-in',
                    'instagram': 'fab fa-instagram',
                    'youtube': 'fab fa-youtube',
                    'tiktok': 'fab fa-tiktok',
                    'github': 'fab fa-github',
                    'snapchat': 'fab fa-snapchat-ghost',
                    'pinterest': 'fab fa-pinterest-p',
                    'reddit': 'fab fa-reddit-alien',
                    'whatsapp': 'fab fa-whatsapp',
                    'telegram': 'fab fa-telegram-plane',
                    'discord': 'fab fa-discord',
                    'threads': 'fab fa-threads', // fallback needed if unavailable
                    'wechat': 'fab fa-weixin',
                    'skype': 'fab fa-skype',
                    'vimeo': 'fab fa-vimeo-v',
                    'dribbble': 'fab fa-dribbble',
                    'behance': 'fab fa-behance',
                    'medium': 'fab fa-medium-m',
                    'tumblr': 'fab fa-tumblr',
                    'slack': 'fab fa-slack',
                    'flickr': 'fab fa-flickr',
                };

                $('.social-saffron a[data-title]').each(function() {
                    const title = $(this).data('title');
                    const iconClass = socialIconMap[title?.toLowerCase()];

                    if (iconClass) {
                        const icon = $('<i>').addClass(iconClass);
                        $(this).prepend(icon);
                    }
                });
            });
        </script>

        <script></script>

        <script src="{{ URL::to('web/libs/toastr/toastr.min.js') }}"></script>
        @if (Session::has('message'))
            <script>
                var type = "{{ Session::get('alert-type') }}";
                toastr[type]("{!! Session::get('message') !!}");
            </script>
        @endif
        @if ($blog_setting)
            {!! $blog_setting?->google_analytic_code !!}
        @endif
    @endif
</body>

</html>
