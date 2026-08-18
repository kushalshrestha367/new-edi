@extends('web.layouts.app')

@push('css')
    <link href="{{ URL::to('web') }}/libs/glightbox/css/glightbox.min.css" rel="stylesheet">
@endpush

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($galleryVideos->isNotEmpty())
                        <div class="container">
                            <div class="row">
                                @foreach ($galleryVideos as $key => $item)
                                    @php
                                        $embed = $item->embed;

                                        $filecode = Str::after($embed, 'https://www.youtube.com/watch?v=');

                                        if (!$filecode || $filecode == $embed) {
                                            $filecode = Str::after($embed, 'https://youtu.be/');
                                        }

                                        if (!$filecode || $filecode == $embed) {
                                            $filecode = Str::after($embed, 'https://www.youtube.com/live/');
                                        }

                                        // remove query params if exists
                                        $filecode = Str::before($filecode, '?');
                                    @endphp
                                    <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay="0.{{ $key + 1 }}s">
                                        <a href="https://www.youtube.com/watch?v={{ $filecode }}"
                                            class="portfolio-lightbox preview-link"
                                            data-glightbox="title: {{ $item->title }}; description: ; type: video">
                                            @if ($item->image_path)
                                                <img src="{{ $item->image_url }}" class="img-fluid w-100 main-gallery"
                                                    alt="{{ $item->title }}">
                                            @else
                                                <img src="https://img.youtube.com/vi/{{ $filecode }}/maxresdefault.jpg"
                                                    class="img-fluid w-100 main-gallery" alt="{{ $item->title }}">
                                            @endif

                                            <h5 class="text-center my-2">{{ $item->title }}</h5>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            @if ($galleryVideos->hasPages())
                                <div class="container pt-5">
                                    {{ $galleryVideos->links() }}
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

@push('js')
    <script src="{{ URL::to('web') }}/libs/glightbox/js/glightbox.min.js"></script>

    <script type="text/javascript">
        const portfolioLightbox = GLightbox({
            selector: '.portfolio-lightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
        });
    </script>
@endpush
