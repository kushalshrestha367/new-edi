@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($departmentData)
                        <div class="container-fluid">
                            <div class="container">

                                <div class="row mb-5">
                                    @if ($departmentData->image_url)
                                        <div class="col-md-3 mb-3 mb-md-0">
                                            <img src="{{ $departmentData->image_url }}" class="img-fluid rounded shadow"
                                                alt="{{ $departmentData->title }}">
                                        </div>
                                    @endif
                                    <div class="col-md-8">
                                        {{-- <h2 class="fw-bold mb-3">{{ $departmentData->title }}</h2> --}}
                                        <div>
                                            {!! $departmentData->description !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    @foreach ($departmentData->items as $departmentitem)
                                        <div class="col-md-6 col-lg-4">
                                            <a href="{{ route('department.item.detail', [$departmentData->slug, $departmentitem->slug]) }}"
                                                class="text-decoration-none d-block h-100">
                                                <div
                                                    class="card h-100 border-0 shadow-sm rounded overflow-hidden position-relative service-card">

                                                    {{-- Image with hover zoom --}}
                                                    <div class="overflow-hidden">
                                                        <img src="{{ $departmentitem->image_url ?? asset('images/no-file.jpg') }}"
                                                            class="img-fluid w-100 service-img transition"
                                                            alt="{{ $departmentitem->title }}">
                                                    </div>

                                                    {{-- Overlay title --}}
                                                    <div class="card-img-overlay d-flex align-items-end p-0">
                                                        <div class="w-100 bg-dark bg-opacity-75 text-center py-2">
                                                            <h5 class="text-uppercase text-white mb-0">
                                                                {{ $departmentitem->title }}
                                                            </h5>
                                                        </div>
                                                    </div>

                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <style>
                                    .service-card .service-img {
                                        transition: transform 0.4s ease;
                                    }

                                    .service-card:hover .service-img {
                                        transform: scale(1.1);
                                    }

                                    .service-card:hover {
                                        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                                    }
                                </style>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
