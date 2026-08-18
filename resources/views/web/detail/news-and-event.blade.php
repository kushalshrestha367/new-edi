@extends('web.layouts.app')

@push('css')
    <link href="{{ URL::to('web') }}/libs/glightbox/css/glightbox.min.css" rel="stylesheet">
@endpush

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md mx-auto">
                                @if ($itemData->image_url)
                                    <img src="{{ $itemData->image_url }}"
                                        class="img-fluid w-50 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $itemData->title }}">
                                @endif

                                <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
                                    <h4 class="fw-bold mb-0" style="letter-spacing: 1px;">
                                        {{ $itemData->title }}
                                    </h4>

                                    <span
                                        class="badge rounded-pill bg-warning text-primary border text-uppercase px-3 py-2 fw-semibold">
                                        {{ str_replace('-', ' ', $itemData->type) }}
                                    </span>
                                </div>

                                @if ($itemData->event_start_date || $itemData->event_end_date || $itemData->event_location)
                                    <span class="d-flex flex-wrap gap-2 align-items-center">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>
                                            @if ($itemData->event_start_date)
                                                {{ date('d M Y', strtotime($itemData->event_start_date)) }}
                                                –
                                            @endif
                                            @if ($itemData->event_end_date)
                                                {{ date('d M Y', strtotime($itemData->event_end_date)) }}
                                            @endif
                                        </span>

                                        @if ($itemData->event_location)
                                            <span class="mx-2">|</span>

                                            <i class="fa-regular fa-map"></i>
                                            <span>{{ $itemData->event_location }}</span>
                                        @endif
                                    </span>
                                @endif

                                @if ($itemData->content)
                                    <div class="my-2">
                                        {!! $itemData->content !!}
                                    </div>
                                @endif
                            </div>

                        </div>
                        @if (!empty($itemData->image_path) && collect($itemData->image_path)->isNotEmpty())
                            <div class="row">
                                @foreach ($itemData->image_path as $key => $item)
                                    <div class="col-md-3 mb-4" data-delay="0.{{ $key + 1 }}s">
                                        <a href="{{ Storage::url($item) }}" data-gallery="portfolioGallery"
                                            class="portfolio-lightbox preview-link" title="{{-- Gallery Image --}}">

                                            <img src="{{ Storage::url($item) }}" class="img-fluid w-100 main-gallery rounded"
                                                alt="Gallery Image">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($itemDataRelated->isNotEmpty())
                            <h4 class="fw-bold mb-4 text-uppercase">Other {{ str_replace('-', ' ', $itemData->type) }}</h4>

                            <div class="row g-4">
                                @foreach ($itemDataRelated as $item)
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('news-and-event.item.detail', $item->slug) }}"
                                            class="text-decoration-none text-dark d-block h-100">

                                            <div class="card h-100 border-0 shadow-sm overflow-hidden related-card">
                                                @if (!empty($item->image_path) && isset($item->image_path[0]))
                                                    <img src="{{ Storage::url($item->image_path[0]) }}"
                                                        class="card-img-top img-fluid related-image rounded"
                                                        alt="{{ $item->title }}">
                                                @else
                                                    <img src="{{ asset('images/no-file.jpg') }}"
                                                        class="card-img-top img-fluid related-image rounded" alt="No Image">
                                                @endif

                                                <div class="card-body p-3">
                                                    <h6 class="fw-semibold mb-0 line-clamp-2">
                                                        {{ $item->title }}
                                                    </h6>
                                                </div>
                                            </div>

                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ URL::to('web') }}/libs/glightbox/js/glightbox.min.js"></script>
    <script type="text/javascript">
        const portfolioLightbox = GLightbox({
            selector: '.portfolio-lightbox'
        });
    </script>
@endpush
