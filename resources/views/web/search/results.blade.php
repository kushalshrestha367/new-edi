@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">

                        {{-- No Results --}}
                        @if (collect($results)->every(fn($items) => $items->isEmpty()))
                            <div class="alert alert-warning">
                                No results found for <strong>{{ $query }}</strong>.
                            </div>
                        @endif

                        {{-- Notice Section --}}
                        @if ($results['notices']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">Notice</h4>
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['notices'] as $notice)
                                        <a href="{{ route('notice.detail', $notice->slug ?? '#') }}"
                                            class="text-decoration-none text-dark border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">
                                            <h6 class="fw-semibold mb-1">{{ $notice->title }}</h6>
                                            <div class="small d-flex gap-3">
                                                <span>
                                                    <i class="fa-regular fa-calendar-days fa-fw me-1"></i>
                                                    {{ $notice->display_date ?? $notice->created_at->format('M d, Y') }}
                                                </span>
                                            </div>

                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Programs --}}
                        @if ($results['programs']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">Available Programs</h4>

                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['programs'] as $program)
                                        <a href="{{ route('program.item.detail', $program->slug ?? '#') }}"
                                            class="text-decoration-none text-dark border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0 fw-semibold">{{ $program->title }}</h6>
                                                <span
                                                    class="badge bg-light text-primary border border-primary rounded-pill small">
                                                    {{ @$program->category->title }}
                                                </span>
                                            </div>

                                            <p class="mb-0 small">
                                                {!! Str::limit(strip_tags($program->description), 120) !!}
                                            </p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Downloads --}}
                        @if ($results['downloads']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">Downloads</h4>

                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['downloads'] as $download)
                                        <div
                                            class="border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="pe-3">
                                                    <a href="{{ route('download.item.detail', $download->slug ?? '#') }}"
                                                        class="text-decoration-none text-dark fw-semibold">
                                                        {{ $download->title }}
                                                    </a>
                                                    <p class="mb-0 small">
                                                        {!! Str::limit(strip_tags($download->description), 120) !!}
                                                    </p>
                                                </div>

                                                @if ($download->files->where('is_active', true)->count())
                                                    @foreach ($download->files->where('is_active', true)->take(1) as $item)
                                                        @if ($item->file_path)
                                                            <a href="{{ Storage::url($item->file_path) }}"
                                                                class="btn btn-sm btn-outline-primary text-nowrap">
                                                                Download
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Careers --}}
                        @if ($results['careers']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">Careers</h4>

                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['careers'] as $career)
                                        <a href="{{ route('career.item.detail', $career->slug ?? '#') }}"
                                            class="text-decoration-none text-dark border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">

                                            <!-- Title -->
                                            <h6 class="fw-semibold mb-3">{{ $career->title }}</h6>

                                            <!-- Job Details Grid -->
                                            <div class="row g-2 small">
                                                <div class="col-6 col-md-4">
                                                    <i class="fa-solid fa-building fa-fw me-1"></i>
                                                    {{ $career->department }}
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <i class="fa-solid fa-location-dot fa-fw me-1"></i>
                                                    {{ $career->location }}
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <i class="fa-solid fa-briefcase fa-fw me-1"></i>
                                                    {{ $career->job_type }}
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <i class="fa-solid fa-user-group fa-fw me-1"></i> Vacancies:
                                                    {{ $career->vacancies }}
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <i class="fa-solid fa-calendar-days fa-fw me-1"></i> Deadline:
                                                    {{ date('d M Y', strtotime($career->deadline)) }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- News Section --}}
                        @if ($results['news']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">News</h4>
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['news'] as $news)
                                        <a href="{{ route('news-and-event.item.detail', $news->slug ?? '#') }}"
                                            class="text-decoration-none text-dark border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">
                                            <h6 class="fw-semibold mb-1">{{ $news->title }}</h6>
                                            <p class="mb-0 small">
                                                {!! Str::limit(strip_tags($news->content), 120) !!}
                                            </p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Events Section --}}
                        @if ($results['events']->count())
                            <div class="mb-4">
                                <h4 class="mb-4 fw-semibold">Events</h4>
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($results['events'] as $event)
                                        <a href="{{ route('news-and-event.item.detail', $event->slug ?? '#') }}"
                                            class="text-decoration-none text-dark border-start border-1 border-light bg-white shadow-sm rounded-end p-3 transition-all hover-lift">
                                            <h6 class="fw-semibold mb-1">{{ $event->title }}</h6>
                                            <div class="small d-flex gap-3">
                                                <span>
                                                    <i class="fa-solid fa-location-dot fa-fw me-1"></i>
                                                    {{ $event->event_location ?? 'Location TBD' }}
                                                </span>
                                                <span>
                                                    <i class="fa-regular fa-calendar-days fa-fw me-1"></i>
                                                    {{ $event->created_at->format('M d, Y') }}
                                                </span>
                                            </div>

                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
