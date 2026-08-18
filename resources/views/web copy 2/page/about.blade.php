@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">
                    @if ($aboutData)
                        <div class="container">
                            {{-- <h1 class="display-6 text-uppercase mb-4">{{ $aboutData->title }}</h1> --}}
                            @if ($aboutData->image_url)
                                <img class="img-fluid w-25 wow fadeIn float-lg-end me-lg-3" data-wow-delay="0.3s"
                                    src="{{ $aboutData->image_url }}" alt="{{ $aboutData->title }}">
                            @endif

                            <div class="wow fadeIn" data-wow-delay="0.5s">
                                @if ($aboutData->description)
                                    <div class="about-description">
                                        {!! $aboutData->description !!}
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

    {{-- @if ($aboutData->achievements->count() || $aboutData->values || $aboutData->mission || $aboutData->vision)
    <section class="py-10 py-lg-12 py-xl-13">
        <div class="container py-5">
            @if ($aboutData->achievements->count())
                <div class="row g-5">
                    @foreach ($aboutData->achievements->sortBy('sort_order') as $achive)
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 btn-xl-square bg-light me-3 text-primary fs-2">
                                    {!! $achive->icon !!}
                                </div>
                                <h5 class="lh-base text-uppercase mb-0">{{ $achive->title }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                @if ($aboutData->values)
                    <div class="mb-5 position-relative">
                        <div class="position-absolute "
                            style="font-size: 5rem; left: -10px; top: 0; opacity: 0.07;  transform: translate(-30%,-30%); z-index: 0;">
                            {!! $aboutData->values->icon !!}
                        </div>

                        <div class="position-relative" style="z-index: 1;">
                            <h5 class="text-uppercase mb-2">{{ $aboutData->values->title }}</h5>
                            <p class="mb-0">{!! $aboutData->values->description !!}</p>
                        </div>
                    </div>
                @endif

                @if ($aboutData->mission)
                    <div class="mb-5 position-relative">
                        <div class="position-absolute"
                            style="font-size: 5rem; left: -10px; top: 0; opacity: 0.07;  transform: translate(-30%,-30%); z-index: 0;">
                            {!! $aboutData->mission->icon !!}
                        </div>

                        <div class="position-relative" style="z-index: 1;">
                            <h5 class="text-uppercase mb-2">{{ $aboutData->mission->title }}</h5>
                            <p class="mb-0">{!! $aboutData->mission->description !!}</p>
                        </div>
                    </div>
                @endif

                @if ($aboutData->vision)
                    <div class="mb-5 position-relative">
                        <div class="position-absolute"
                            style="font-size: 5rem; left: -10px; top: 0; opacity: 0.07;  transform: translate(-30%,-30%); z-index: 0;">
                            {!! $aboutData->vision->icon !!}
                        </div>

                        <div class="position-relative" style="z-index: 1;">
                            <h5 class="text-uppercase mb-2">{{ $aboutData->vision->title }}</h5>
                            <p class="mb-0">{!! $aboutData->vision->description !!}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
    @endif --}}

@endsection
