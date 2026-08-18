@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            @if ($contactData)
                <div class="card flex-direction-initial">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-md">
                                <h4 class="text-uppercase mb-4">
                                    <i class="fas fa-building me-2 text-primary"></i> Contact Information
                                </h4>

                                <ul class="list-unstyled text-muted">
                                    @if ($contactData->address)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Address:</strong>
                                                {{ $contactData->address }}</span>
                                        </li>
                                    @endif

                                    @if ($contactData->phone)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-phone-alt text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Phone:</strong> {{ $contactData->phone }}</span>
                                        </li>
                                    @endif

                                    @if ($contactData->fax)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-fax text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Fax:</strong> {{ $contactData->fax }}</span>
                                        </li>
                                    @endif

                                    @if ($contactData->email)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Email:</strong> {{ $contactData->email }}</span>
                                        </li>
                                    @endif
                                </ul>

                            </div> --}}

                            @if ($timetable->isNotEmpty())
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <div>
                                            <h2 class="h3 fw-bold text-dark mb-1">Schedule Timetable</h2>
                                            <p class="text-muted mb-0 small">Overview of weekly operational hours</p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                <i class="bi bi-calendar-check me-1 text-primary"></i>
                                                Today : {{ date('D, M d, Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs border-0 gap-2 mb-4" id="timetableTabs" role="tablist">
                                        @foreach ($timetable as $day => $slots)
                                            <li class="nav-item">
                                                <button
                                                    class="nav-link px-3 py-1 rounded-pill {{ $day === $today ? 'active bg-primary text-white' : 'bg-light text-primary' }} border-0"
                                                    data-bs-toggle="tab" data-bs-target="#tab-{{ $loop->index }}">
                                                    {{ $day }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content bg-white shadow-sm rounded-4 border p-4">
                                        @foreach ($timetable as $day => $slots)
                                            <div class="tab-pane fade {{ $day === $today ? 'show active' : '' }}"
                                                id="tab-{{ $loop->index }}">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <h5 class="fw-bold">{{ $day }} Schedule</h4>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        <span class="text-muted small">Showing {{ $slots->count() }} active
                                                            sessions</span>
                                                    </div>
                                                </div>

                                                <div class="timetable-grid">
                                                    @foreach ($slots as $slot)
                                                        <div class="row py-3 border-bottom align-items-center hover-row">
                                                            <div class="col-md-4">
                                                                <div class="fw-semibold text-dark">{{ $slot->subject }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <i class="bi bi-clock text-primary me-2"></i>
                                                                <span
                                                                    class="text-muted">{{ date('h:i A', strtotime($slot->start_time)) }}
                                                                    —
                                                                    {{ date('h:i A', strtotime($slot->end_time)) }}</span>
                                                            </div>
                                                            <div class="col-md-4 text-md-end">
                                                                <span
                                                                    class="badge rounded-pill bg-soft-success text-success px-3">
                                                                    <i class="bi bi-circle-fill small me-1"></i> Open
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($contactData->latitude && $contactData->longitude)
                                <div class="col-md-6">
                                    <div class="ratio ratio-16x9 shadow rounded"
                                        style="max-height: 300px; overflow: hidden;">
                                        <iframe
                                            src="https://maps.google.com/maps?q={{ $contactData->latitude }},{{ $contactData->longitude }}&z=15&output=embed"
                                            width="100%" height="100%" style="border:0;" allowfullscreen=""
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>

                    {{-- <div class="position-fixed bottom-0 end-0 m-3" style="z-index:1050;">
                        <div class="card border-danger shadow-lg" style="width: 300px;">
                            <div class="card-header bg-danger text-white fw-bold">
                                🚨 Emergency Contacts
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($emergencyData as $emelement)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{!! $emelement->icon !!} {{ $emelement->title }}</div>
                                            <small class="text-muted">{!! $emelement->description !!}</small>
                                        </div>
                                        <a href="tel:{{ $emelement->phone }}" class="btn btn-sm btn-danger">📞</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div> --}}

                    <div class="my-5">
                        {{-- <h2 class="text-center text-danger fw-bold mb-4">🚨 Emergency Contacts</h2> --}}

                        <div class="list-group shadow-sm rounded">
                            @foreach ($emergencyData as $emelement)
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="fs-1">{!! $emelement->icon !!}</span>
                                        <div>
                                            <div class="fw-bold">{{ $emelement->title }}</div>
                                            <small>{!! $emelement->description !!}</small>
                                        </div>
                                    </div>
                                    <a href="tel:{{ $emelement->phone }}" class="btn btn-outline-primary fw-bold">
                                        📞 {{ $emelement->phone }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    @if ($contactData->branches->count())
                        <div class="row">
                            <div class="col-12 mb-4">
                                <h4 class="text-uppercase border-start border-4 border-primary ps-3">
                                    Branch Offices
                                </h4>
                            </div>

                            @foreach ($contactData->branches as $branch)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="bg-white p-4 border rounded h-100 shadow-sm hover-shadow">
                                        <h5 class="text-uppercase mb-3 text-primary">
                                            <i class="fas fa-building me-2"></i>{{ $branch->name }}
                                        </h5>
                                        <ul class="list-unstyled mb-0 text-muted small">
                                            @if ($branch->address)
                                                <li class="mb-2 d-flex align-items-start">
                                                    <i class="fas fa-map-marker-alt text-primary me-2 mt-1"></i>
                                                    <span>{{ $branch->address }}</span>
                                                </li>
                                            @endif

                                            @if ($branch->phone)
                                                <li class="mb-2 d-flex align-items-start">
                                                    <i class="fas fa-phone-alt text-primary me-2 mt-1"></i>
                                                    <span>{{ $branch->phone }}</span>
                                                </li>
                                            @endif

                                            @if ($branch->fax)
                                                <li class="mb-2 d-flex align-items-start">
                                                    <i class="fas fa-fax text-primary me-2 mt-1"></i>
                                                    <span>{{ $branch->fax }}</span>
                                                </li>
                                            @endif

                                            @if ($branch->email)
                                                <li class="mb-2 d-flex align-items-start">
                                                    <i class="fas fa-envelope text-primary me-2 mt-1"></i>
                                                    <span>{{ $branch->email }}</span>
                                                </li>
                                            @endif

                                            @if ($branch->latitude && $branch->longitude)
                                                <li class="mb-2 d-flex align-items-start">
                                                    <a href="{{ route('contact.branch.detail', $branch->id) }}">
                                                        <i class="fas fa-street-view text-primary me-2 mt-1"></i>
                                                        <span>Visit us</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="container d-flex flex-column justify-content-center align-items-center text-center">
                        <h1 class="mb-3 fw-bold text-primary">🚧 Update Coming Soon</h1>
                        <p class="text-muted mb-4">
                            We’re working hard to bring you the latest updates. Please check back soon!
                        </p>
                    </div>
            @endif

        </div>
    </section>

@endsection
