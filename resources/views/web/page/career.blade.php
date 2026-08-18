@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($listDatas->isNotEmpty())
                        <div class="container">
                            <div class="row g-4">

                                @foreach ($listDatas as $index => $item)
                                    <div class="col-md-12 mb-4">
                                        <div class="card h-100 shadow-sm border-0 career-card overflow-hidden">
                                            <div class="card-body p-md-4 p-2">
                                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                                                    <div class="flex-grow-2 text-center text-md-end {{-- d-none d-md-block --}} w-100 w-md-auto rounded bg-info-subtle p-2">
                                                        <div class="small  mb-1">Apply By</div>
                                                        <div class="fw-bold text-dark">
                                                            {{ date('d M Y', strtotime($item->deadline)) }}</div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="{{ route('career.item.detail', $item->slug) }}">
                                                            <h5 class="fw-bold text-dark mb-3">{{ $item->title }}</h5>
                                                        </a>

                                                        <div class="d-flex flex-wrap gap-4  small">
                                                            <span><i class="fa-solid fa-building me-1 text-primary"></i>
                                                                {{ $item->department }}</span>
                                                            <span><i class="fa-solid fa-location-dot me-1 text-primary"></i>
                                                                {{ $item->location }}</span>
                                                            <span><i class="fa-solid fa-briefcase me-1 text-primary"></i>
                                                                {{ $item->job_type }}</span>
                                                            <span><i class="fa-solid fa-user-group me-1 text-primary"></i>
                                                                Vacancies : {{ $item->vacancies }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="align-self-center">
                                                        <a href="{{ route('career.item.detail', $item->slug) }}"
                                                            class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                                                            View Position <i class="fa-solid fa-arrow-right ms-1"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                        /* Professional Accent Line Effect */
                                        .career-card {
                                            border-left: 5px solid transparent !important;
                                            transition: all 0.3s ease;
                                        }

                                        .career-card:hover {
                                            border-left: 5px solid var(--bs-primary) !important;
                                            transform: translateX(5px);
                                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
                                        }

                                        .btn-primary {
                                            transition: all 0.3s;
                                        }

                                        .btn-primary:hover {
                                            transform: scale(1.05);
                                        }
                                    </style>
                                @endforeach

                                {{-- paginate --}}
                                @if ($listDatas->hasPages())
                                    <div class="mt-4">
                                        {{ $listDatas->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @include('web.layouts.404')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
