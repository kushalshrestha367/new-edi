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

                    <div class="container pb-6">
                        <div class="mb-3">
                            {!! $galleryInfo->description !!}
                        </div>
                        @if ($galleryDatas->isNotEmpty())
                            <div class="row">
                                @forelse ($galleryDatas as $key => $item)
                                    <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay="0.{{ $key + 1 }}s">
                                        <a href="{{ Storage::url($item->image_path) }}" data-gallery="portfolioGallery"
                                            class="portfolio-lightbox preview-link" title="{{ $item->caption }}">
                                            <img src="{{ Storage::url($item->image_path) }}"
                                                class="img-fluid w-100 main-gallery" alt="{{ $item->caption }}">
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-lg-6">
                                        <h1 class="display-1">Update Coming soon</h1>
                                        <a class="btn btn-primary py-3 px-5" href="{{ route('welcome') }}">Go Back To
                                            Home</a>
                                    </div>
                                @endforelse
                            </div>

                            @if ($galleryDatas->hasPages())
                                <div class="container pt-5">
                                    {{ $galleryDatas->links() }}
                                </div>
                            @endif
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
