@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($newsAndEventDatas->isNotEmpty())
                        <div class="container">
                            <div class="row g-4">

                                @foreach ($newsAndEventDatas as $index => $item)
                                    @if ($index === 0)
                                        <div class="col-12">
                                            <div class="card border-0 overflow-hidden">
                                                <div class="row g-0 align-items-stretch">

                                                    <div class="col-md-5">
                                                        @if (!empty($item->image_path) && isset($item->image_path[0]))
                                                            <img src="{{ Storage::url($item->image_path[0]) }}"
                                                                class="img-fluid h-100 w-100"
                                                                style="object-fit: cover; min-height: 300px;"
                                                                alt="{{ is_string($item->title) ? $item->title : '' }}">
                                                        @else
                                                            <img src="{{ asset('images/no-file.jpg') }}"
                                                                class="card-img-top img-fluid related-image" alt="No Image">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-7">
                                                        <div class="card-body p-4 p-lg-5">
                                                            @if (is_string($item->type))
                                                                <span class="badge bg-primary mb-2 text-uppercase">
                                                                    {{ $item->type }}
                                                                </span>
                                                            @endif
                                                            <div class="h-100 d-flex flex-column justify-content-center">
                                                                <h3 class="fw-bold mb-3">
                                                                    {{ is_string($item->title) ? $item->title : '' }}
                                                                </h3>

                                                                @if (!empty($item->content) && is_string($item->content))
                                                                    <p class="text-muted mb-2">
                                                                        {!! Str::limit($item->content, 140) !!}
                                                                    </p>
                                                                @endif

                                                                <a
                                                                    href="{{ route('news-and-event.item.detail', $item->slug) }}">
                                                                    Read More →
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @elseif($index > 0 && $index < 4)
                                        <div class="col-md-4">
                                            <a href="{{ route('news-and-event.item.detail', $item->slug) }}"
                                                class="px-0">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="position-relative w-100">
                                                        @if ($item->image_path[0])
                                                            <img src="{{ Storage::url($item->image_path[0]) }}"
                                                                class="card-img-top img-fluid related-image"
                                                                alt="{{ $item->title }}" style="object-fit:cover;">
                                                        @else
                                                            <img src="{{ asset('images/no-file.jpg') }}"
                                                                class="card-img-top img-fluid related-image" alt="No Image">
                                                        @endif
                                                        <span
                                                            class="badge bg-site-secondary text-capitalize position-absolute top-0 start-0 m-3">
                                                            {{ $item->type }}
                                                        </span>
                                                    </div>

                                                    <div class="card-body no-b-space">

                                                        <h5 class="fw-semibold link-hover">
                                                            {{ $item->title }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="fw-semibold">
                                                        {{ $item->title }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                {{-- paginate --}}
                                @if ($newsAndEventDatas->hasPages())
                                    <div class="mt-4">
                                        {{ $newsAndEventDatas->links('pagination::bootstrap-5') }}
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
