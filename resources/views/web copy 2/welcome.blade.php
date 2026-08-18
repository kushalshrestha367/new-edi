@extends('web.layouts.app')

@push('loader')
    @include('web.layouts.loader')
@endpush

@push('css-top')
    <link rel="stylesheet" href="{{ asset('web/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@section('content')
    @if ($notice_pop->isNotEmpty())
        @foreach ($notice_pop as $key => $nelement)
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="noticepop{{ $key + 1 }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><i
                                    class="fa fa-exclamation-circle"></i>Notice</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <a href="{{ route('notice.detail', $nelement->slug) }}">
                                @if ($nelement->image_path)
                                    <img src="{{ Storage::url($nelement->image_path) }}" alt="{{ $nelement->title }}"
                                        class="img-fluid">
                                @endif
                                <h4 class="text-center my-2">{{ $nelement->title }}</h4>
                            </a>
                            @if ($nelement->file_path)
                                <div class="text-center mt-2">
                                    <a href="{{ Storage::url($nelement->file_path) }}" class="text-danger" target="_blank">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Hero --}}
    @include('web.layouts.hero')

    {{-- Partner --}}
    <section class="logo-ipsum py-10 py-lg-12 py-xl-12">
        <div class="container position-relative z-3">
            <div class="d-flex flex-column gap-9">
                @if (@$affiliated_with)
                    <div class="row position-relative hstack justify-content-center">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <hr class="border-2 w-20 d-block">
                                <p class="mb-0 text-center flex-sm-shrink-0">Affiliated with {{ $affiliated_with }} </p>
                                <hr class="border-2 w-20 d-block">
                            </div>
                        </div>
                    </div>
                @endif

                @if ($partnerDatas->isNotEmpty())
                    <div class="marquee w-100 d-flex align-items-center overflow-hidden">
                        <div class="marquee-content d-flex align-items-center justify-content-between gap-11">
                            @foreach ($partnerDatas as $partner)
                                <div class="marquee-tag hstack justify-content-center">
                                    <img src="{{ asset($partner->image_url) }}" alt="{{ $partner->title }}"
                                        class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Count Section --}}
    @if ($counterData)
        <section class="py-10 py-lg-12 py-xl-13" id="programs">
            <div class="container position-relative z-3">
                <div class="d-flex flex-column gap-10 gap-lg-12">
                    <div class="d-flex flex-column gap-3">
                        @if ($counterData)
                            <h2 class="mb-0 text-center" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                                {!! $counterData->description !!}
                            </h2>
                        @endif
                        @if ($programData->isNotEmpty())
                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-3" data-aos="fade-up"
                                data-aos-delay="200" data-aos-duration="1000">
                                @foreach ($programData as $key => $programs)
                                    @php
                                        $colors = ['primary', 'secondary', 'info', 'orange', 'danger'];
                                    @endphp
                                    <a href="{{ route('program.item.detail', $programs->slug) }}">
                                        <div class="rounded-pill py-1 px-8 hstack gap-7 bg-{{ $colors[$key] }}-subtle">
                                            <i class="fa-solid fa-graduation-cap text-{{ $colors[$key] }}"></i>
                                            <h2 class="mb-0 text-{{ $colors[$key] }} font-instrument">
                                                <em>{{ $programs->short_form ?? $programs->title }}</em>
                                            </h2>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if ($counterData && !empty($counterData->counter))
                        <div class="row gap-0 gap-lg-0 border-md-none">
                            @foreach ($counterData->counter as $ci => $item)
                                <div class="col-6 col-md border-end" data-aos="fade-up"
                                    data-aos-delay="{{ $ci + 1 }}00" data-aos-duration="1000">
                                    <div class="d-flex flex-column gap-2 text-center">
                                        <h2 class="mb-0 fs-10 d-flex align-items-start justify-content-center">
                                            <span class="fs-9 lh-1">+</span>
                                            <span class="count" data-target="{{ $item['value'] ?? 0 }}">
                                                {{ $item['value'] ?? 0 }}
                                            </span>
                                        </h2>
                                        <p>{{ $item['label'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @else
        <section class="py-10 py-lg-12 py-xl-13" id="programs">
            <div class="container">
                <div class="d-flex flex-column gap-3">
                    @if ($programData->isNotEmpty())
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3" data-aos="fade-up"
                            data-aos-delay="200" data-aos-duration="1000">
                            @foreach ($programData as $key => $programs)
                                @php
                                    $colors = ['primary', 'secondary', 'info', 'orange', 'danger'];
                                @endphp
                                <div class="rounded-pill py-1 px-8 hstack gap-7 bg-{{ $colors[$key] }}-subtle">
                                    <i class="fa-solid fa-graduation-cap text-{{ $colors[$key] }}"></i>
                                    <h2 class="mb-0 text-{{ $colors[$key] }} font-instrument">
                                        <em>{{ $programs->short_form ?? $programs->title }}</em>
                                    </h2>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Facility  --}}
    @if ($serviceDatas)
        <section class="innovation-meets py-10 py-lg-12 py-xl-13" id="facilities">
            <div class="container">
                <div class="d-flex flex-column gap-10 gap-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-xl-4">
                            @php
                                $fullTitle = $serviceDatas->title;

                                $words = explode(' ', $fullTitle);
                                $emphasized = implode(' ', array_splice($words, -3));
                                $static = implode(' ', $words);
                            @endphp
                            <h2 class="mb-0 text-center" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                                {{ $static }} <em class="font-instrument">{{ $emphasized }}</em>
                            </h2>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-4">
                        <div class="row justify-content-center">
                            @foreach ($serviceDatas['items'] as $i => $item)
                                @php
                                    $icolors = ['primary', 'info', 'secondary', 'orange', 'danger', 'success'];
                                @endphp
                                <div class="col-sm-6 col-md-4 col-lg">
                                    <a href="{{ route('service.item.detail', $item->slug) }}">
                                        <div class="card h-100 bg-{{ $icolors[$i] }}-subtle" data-aos="fade-up"
                                            data-aos-delay="100" data-aos-duration="1000">
                                            <div class="card-body d-flex flex-column gap-11">
                                                @if ($item->icon)
                                                    @php
                                                        preg_match('/class="([^"]+)"/', $item->icon, $matches);
                                                        $fullClasses = $matches[1] ?? '';

                                                        $cleanClasses = str_replace(
                                                            ['fs-9', '  '],
                                                            ['', ' '],
                                                            $fullClasses,
                                                        );
                                                    @endphp
                                                    <i
                                                        class="{{ trim($cleanClasses) }} fs-9 text-{{ $icolors[$i] }}"></i>
                                                @endif
                                                <h4 class="text-{{ $icolors[$i] }} mb-0">
                                                    @php
                                                        $parts = explode(' ', $item->title, 2);
                                                        $firstWord = $parts[0];
                                                        $rest = isset($parts[1])
                                                            ? str_replace('&', '&', $parts[1])
                                                            : '';
                                                    @endphp

                                                    <span>{{ $firstWord }}</span><br>
                                                    {!! $rest !!}
                                                </h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>

                        <div class="card bg-dark bg-img-facility mb-0">
                            {{-- <div class="bg-overlay"></div> --}}
                            <div class="card-body px-lg-5">
                                <div class="row align-items-center justify-content-between gap-4 gap-lg-0">

                                    <div class="col-lg-4">
                                        <h3 class="mb-0 text-white text-center text-lg-start text-shadow">
                                            Learn, Grow, and Succeed with World-Class Facilities
                                        </h3>
                                    </div>

                                    <div class="col-lg-8">
                                        <div
                                            class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end gap-7">

                                            {{-- <a href="{{ route('appointment.create') }}" class="btn btn-white hover-btn">
                                                <span class="btn-text">Apply Now</span>
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a> --}}

                                            <a href="{{ route('program') }}" class="btn btn-outline-light hover-btn">
                                                <span class="btn-text">Explore Programs</span>
                                                <i class="fas fa-graduation-cap ms-2"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Team Section --}}
    @if ($teamDatas->isNotEmpty())
        <section class="py-10 py-lg-12 py-xl-13" id="messageFromSection">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="80">The
                        creative minds behind <em class="font-instrument">our success</em></h2>
                </div>

                <div id="msgFrom" class="swiper msgFrom overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($teamDatas as $team)
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-lg-3 d-flex align-items-stretch">
                                        <div class="card w-100 shadow p-0 m-0" data-aos="fade-up" data-aos-delay="300"
                                            data-aos-duration="1000">
                                            <div class="card-body p-0 m-0 overflow-hidden rounded">
                                                <img src="{{ $team->image_url }}" alt="customer-stories"
                                                    class="img-fluid w-100 msg-from-img">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 d-flex align-items-stretch">
                                        <div class="card mb-0 bg-light position-relative w-100" data-aos="fade-up"
                                            data-aos-delay="400" data-aos-duration="1000">
                                            <div
                                                class="card-body d-flex flex-column justify-content-between gap-14 gap-lg-11">
                                                <div class="d-flex flex-column gap-4">
                                                    <p class="mb-0 text-uppercase fw-medium fs-3 text-muted">A Warm Welcome
                                                    </p>
                                                    <div class="mb-0 fw-medium fs-5">
                                                        {!! Str::limit(strip_tags($team->message), 500, '...') !!}
                                                        <a href="{{ route('team.detail', $team->slug) }}"
                                                            class="ms-2 small">Read all <i
                                                                class="fas fa-arrow-right ms-2"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column gap-1">
                                                    <h6 class="mb-0">{{ $team->name }}</h6>
                                                    <p class="mb-0 fw-medium fs-3">
                                                        {!! $team->designation !!}
                                                        @if ($team->academic)
                                                            <br>
                                                            {{ $team->academic }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination swiper-pagination-msg"></div>
                </div>
                <div class="d-md-flex align-items-center justify-content-center mt-10" data-aos="fade-up"
                    data-aos-delay="300" data-aos-duration="1000">
                    <a href="{{ route('team') }}"
                        class="btn btn-primary py-md-6 pe-md-13 mx-auto mx-md-0 d-block d-md-flex">
                        <span class="btn-text">See All</span>
                        <iconify-icon icon="solar:arrow-right-up-linear"
                            class="btn-icon bg-white text-dark round-32 rounded-circle hstack justify-content-center fs-6"></iconify-icon>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @include('web.notice.sections')

    {{-- NEWS & EVENTS --}}
    @if ($newseventDatas->isNotEmpty())
        <section id="news">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-5">
                    <div>
                        <div class="section-eyebrow" data-aos="fade-up">News & Events</div>
                        <h2 class="section-title" data-aos="fade-up" data-aos-delay="80">Latest from <em
                                class="font-instrument">{{ $site_title ?? config('app.name', 'Saffron Infosys Pvt. Ltd.') }}</em>
                        </h2>
                    </div>

                    <div class="d-md-flex align-items-center justify-content-center mt-10" data-aos="fade-up"
                        data-aos-delay="300" data-aos-duration="1000">
                        <a href="{{ route('news-and-event') }}"
                            class="btn btn-primary py-md-6 pe-md-13 mx-auto mx-md-0 d-block d-md-flex">
                            <span class="btn-text">See All</span>
                            <iconify-icon icon="solar:arrow-right-up-linear"
                                class="btn-icon bg-white text-dark round-32 rounded-circle hstack justify-content-center fs-6"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($newseventDatas as $newsevent)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                            <div class="news-card">
                                <div class="news-img-wrap">
                                    @if (!empty($newsevent->image_path) && isset($newsevent->image_path[0]))
                                        <img src="{{ Storage::url($newsevent->image_path[0]) }}" class="news-img"
                                            alt="{{ is_string($newsevent->title) ? $newsevent->title : '' }}">
                                    @else
                                        <img src="{{ asset('images/no-file.jpg') }}" class="news-img" alt="No Image">
                                    @endif
                                    @if (is_string($newsevent->type))
                                        <span class="news-category">{{ $newsevent->type }}</span>
                                    @endif
                                </div>
                                <div class="news-body">
                                    <div class="news-date">
                                        <i class="bi bi-calendar3"></i>
                                        {{ date('M d, Y', strtotime($newsevent->created_at)) }}
                                        -
                                        <i class="small">
                                            {!! $newsevent->created_at->diffInDays(now()) < 5
                                                ? $newsevent->created_at->diffForHumans()
                                                : $newsevent->created_at->format('Y') !!}
                                        </i>
                                    </div>
                                    <h3 class="news-title"><a
                                            href="{{ route('news-and-event.item.detail', $newsevent->slug) }}">{{ $newsevent->title }}</a>
                                    </h3>
                                    @if (!empty($newsevent->content) && is_string($newsevent->content))
                                        <p class="news-excerpt">
                                            {!! Str::limit($newsevent->content, 145) !!}
                                        </p>
                                    @endif
                                    <a href="{{ route('news-and-event.item.detail', $newsevent->slug) }}"
                                        class="news-link">Read More <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- TESTIMONIALS --}}
    @if ($testimonialDatas->isNotEmpty())
        <section id="testimonials" class="py-10 py-lg-12 py-xl-13">
            <div class="container">
                <div class="text-center mb-5">
                    <div class="section-eyebrow justify-content-center" data-aos="fade-up">Student Voices</div>
                    <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="80">What Our <span>Alumni
                            Say</span></h2>
                    <p class="section-sub mx-auto" data-aos="fade-up" data-aos-delay="160">
                        Hear from the graduates who are now leading teams across the world's finest hotels and
                        restaurants.
                    </p>
                </div>
                <div class="swiper" id="testiSwiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">
                        @foreach ($testimonialDatas as $tList)
                            <div class="swiper-slide">
                                <div class="testi-card">
                                    <div class="testi-quote-icon"><i class="bi bi-quote"></i></div>
                                    <div class="testi-text">
                                        {!! $tList->description !!}
                                    </div>
                                    <div class="testi-author">
                                        <img src="{{ Storage::url($tList->image_path) }}" alt="{{ $tList->name }}"
                                            class="testi-avatar" />
                                        <div>
                                            <div class="testi-name">{{ $tList->name }}</div>
                                            <div class="testi-role">{{ $tList->designation }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination mt-4 position-relative" style="bottom:0;margin-top:32px"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- @if ($sliderDatas->isNotEmpty())
    <div class="marquee-container">
        <div class="marquee-track">
            @foreach ($sliderDatas as $slider)
                <img src="{{ $slider->image_url }}" alt="{!! $slider->slider_title !!}" class="img-fluid">
            @endforeach
        </div>
    </div>
    @endif --}}

@endsection

@push('js-top')
    <script>
        $(window).on("load", function(e) {
            setTimeout(function() {
                $('#noticepop1').modal('show');
                $('#noticepop2').modal('show');
                $('#noticepop3').modal('show');
                $('#noticepop4').modal('show');
                $('#noticepop5').modal('show');
            }, 1000);
        });
    </script>
    <script src="{{ asset('web/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush
@push('js-down')
@endpush
