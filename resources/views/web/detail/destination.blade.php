@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row g-5 align-items-start">
                            {{-- @if ($destinationData->image_url)
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.2s">
                                <img src="{{ $destinationData->image_url }}" class="img-fluid w-100 rounded shadow" alt="{{ $destinationData->country }}">
                            </div>
                            @endif --}}

                            @if ($destinationData->description)
                                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.4s">
                                    <p>{!! $destinationData->description !!}</p>
                                </div>
                            @endif
                            @if ($destinationData->video)
                                <div class="ratio ratio-16x9 mt-4">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($destinationData->video, 'v=') }}"
                                        title="Destination Video" allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Reasons to Visit --}}
                    {{-- @if ($destinationData->reasons->where('is_active', true)->count())
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-12 text-center wow fadeInUp">
                                <h3 class="text-uppercase"> Reasons for studying in  {{ $destinationData->country }}?</h3>
                            </div>
                        </div>

                        <div class="row g-4">
                            @foreach ($destinationData->reasons->where('is_active', true)->sortBy('sort_order') as $reason)
                            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="bg-light p-4 border rounded h-100 shadow-sm hover-shadow">
                                    <h5 class="text-uppercase mb-2">{{ $reason->title }}</h5>
                                    <p class="mb-0">{!! $reason->description !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif --}}

                    @if ($destinationData->reasons->where('is_active', true)->count())
                        <div class="container">
                            <div class="row mb-5">
                                <div class="col-12 text-center wow fadeInUp">
                                    <h3 class="text-uppercase fw-bold">Reasons for Studying in
                                        {{ $destinationData->country }}</h3>
                                    <p class="text-muted">Explore why {{ $destinationData->country }} is a top choice for
                                        international education</p>
                                </div>
                            </div>

                            <div class="row justify-content-center g-4">
                                @foreach ($destinationData->reasons->where('is_active', true)->sortBy('sort_order')->values() as $index => $reason)
                                    <div class="col-md-6 col-lg-4 wow fadeInUp"
                                        data-wow-delay="{{ 0.1 + $index * 0.1 }}s">
                                        <div
                                            class="reason-card position-relative h-100 bg-white p-4 rounded shadow-sm border border-light">

                                            <h5 class="text-uppercase fw-semibold mb-2">{{ $reason->title }}</h5>
                                            <p class="text-muted mb-0">{!! $reason->description !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
