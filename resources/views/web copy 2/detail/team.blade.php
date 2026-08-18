@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                @if ($team->image_url)
                                    <img src="{{ $team->image_url }}"
                                        class="img-fluid mb-2 me-3 w-25 rounded shadow float-start" alt="{{ $team->title }}">
                                @endif

                                <h2 class="text-uppercase mb-0">{{ $team->name }}</h2>
                                <p class="fst-italic mb-3 text-primary">{!! $team->designation !!}, {{ $team->academic }}</p>
                                @if ($team->message)
                                    <div>
                                        {!! $team->message !!}
                                    </div>
                                @endif

                            </div>
                            @if ($team->bio)
                                <div>
                                    <h4>Bio</h4>
                                    {!! $team->bio !!}
                                </div>
                            @endif

                            @if ($team->media->count())
                                <div class="mt-4 social-saffron">
                                    <h4 class="d-inline me-2">Connect on:</h4>
                                    <ul class="list-inline d-inline">
                                        @foreach ($team->media->where('is_active', true)->whereNotNull('url') as $media)
                                            <li class="list-inline-item">
                                                <a href="{{ $media->url }}" target="_blank"
                                                    data-title="{{ strtolower($media->platform) }}"
                                                    class="me-2 btn btn-outline-dark btn-social p-2 py-1">
                                                    {{-- icon will be injected by JS --}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
