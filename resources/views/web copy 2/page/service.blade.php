@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($serviceDatas)
                        <div class="container">
                            <div class="row">
                                <h1>{{ $serviceDatas->title }}</h1>
                                <div class="col-12 mb-4">
                                    <p class="text-muted">{!! $serviceDatas->description !!}</p>
                                </div>
                            </div>

                            {{-- Items with Images --}}
                            @if ($serviceDatas->items->count())
                                <div class="row g-4 mb-5">
                                    @foreach ($serviceDatas->items as $item)
                                        <div class="col-md-6 col-lg-4">
                                            <a href="{{ route('service.item.detail', $item->slug) }}"
                                                class="text-decoration-none">
                                                <div
                                                    class="card service-card overflow-hidden rounded-4 shadow-sm h-100 position-relative">
                                                    @if ($item->image_url)
                                                        <img src="{{ $item->image_url }}" class="card-img-top service-img"
                                                            alt="{{ $item->title }}"
                                                            style="height:220px; object-fit:cover;">
                                                    @endif
                                                    <div
                                                        class="card-body text-center p-3 d-flex flex-column justify-content-center bg-light">
                                                        <h5 class="fw-bold mb-2">{{ $item->title }}</h5>
                                                        {{-- <p class="text-muted small mb-3">{{ Str::limit(strip_tags($item->description ?? ''), 60) }}</p> --}}
                                                        <span class="arrow-link text-primary fw-bold">
                                                            Explore <i class="fas fa-arrow-right ms-1"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Extras --}}
                            @if ($serviceDatas->extras->count())
                                <div class="row g-4">
                                    <div class="col-12 mb-3">
                                        <h4 class="text-uppercase border-start border-4 border-primary ps-3">Additional
                                            Services</h4>
                                    </div>

                                    @foreach ($serviceDatas->extras as $extra)
                                        <div class="col-md-6 col-lg-6">
                                            <div class="d-flex align-items-start">
                                                <div class="me-2 text-primary fs-5">
                                                    <i class="far fa-check-circle"></i>
                                                </div>
                                                <div class="my-auto">
                                                    <h6 class="text-uppercase mb-0">{{ $extra->title }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        @include('web.layouts.404')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
