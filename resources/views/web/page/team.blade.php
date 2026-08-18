@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">
                    @if ($teamDatas->isNotEmpty())
                        <div class="d-flex flex-column gap-10 gap-lg-12">
                            <div class="row justify-content-center gap-6 gap-lg-0">
                                @foreach ($teamDatas as $ti => $team)
                                    <div class="col-sm-6 col-lg-2 mb-11 mb-lg-0">
                                        <div class="team d-flex flex-column align-items-center gap-4" data-aos="fade-up"
                                            data-aos-delay="{{ $ti + 1 }}00" data-aos-duration="1000">
                                            <a href="{{ route('team.detail', $team->slug) }}">
                                                <div class="team-img">
                                                    <img src="{{ $team->image_url }}" alt="team"
                                                        class="img-fluid team-img-size shape-blob">
                                                </div>
                                            </a>
                                            <div class="team-details text-center d-flex flex-column gap-3">
                                                <a href="{{ route('team.detail', $team->slug) }}">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h6 class="mb-0">{{ $team->name }}</h6>
                                                        <p class="mb-0">{!! $team->designation !!}, {!! $team->academic !!}</p>
                                                    </div>
                                                </a>
                                                @if ($team->media->count())
                                                    <div class="hstack justify-content-center gap-3 social-saffron">
                                                        @foreach ($team->media->where('is_active', true)->whereNotNull('url') as $media)
                                                            <a href="{{ $media->url }}" target="_blank"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="{{ strtolower($media->platform) }}"
                                                                data-title="{{ strtolower($media->platform) }}"
                                                                class="fs-6 hstack position-relative">
                                                                {{-- icon will be injected by JS --}}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @include('web.layouts.404')
                    @endif
                </div>
            </div>
    </section>
@endsection
