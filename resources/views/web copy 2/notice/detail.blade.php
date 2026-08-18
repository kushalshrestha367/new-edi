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

                    <div class="container-fluid" data-delay="0.1s">
                        @if ($data_list)
                            <div class="container">
                                <div class="row g-5 align-items-start">

                                    {{-- Content Section --}}
                                    <div class="col-lg{{ !$data_list->file_path && $data_list->image_path ?? '-5' }}">
                                        <h4 class="mb-0 text-primary fw-bold">
                                            {!! $data_list->title !!}
                                        </h4>
                                        <span class="small mb-3">
                                            <i class="fa-regular fa-calendar-days"></i>
                                            {{ date_create($data_list->date_show ?? $data_list->created_at)->format('M d, Y') }}
                                        </span>
                                        <div class="content-text mt-3">
                                            {!! $data_list->description !!}
                                        </div>

                                        @if ($data_list->file_path && $data_list->image_path)
                                            <a href="{{ Storage::url($data_list->image_path) }}"
                                                data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                                title="{{ $data_list->title }}">
                                                <img src="{{ Storage::url($data_list->image_path) }}"
                                                    class="img-fluid w-50 border p-1" alt="{{ $data_list->title }}">
                                            </a>
                                        @endif
                                    </div>

                                    {{-- File Section --}}
                                    @if ($data_list->file_path)
                                        <div class="col-lg-7">
                                            <div class="card border-0 shadow-sm">
                                                <div class="ratio ratio-4x3">
                                                    <iframe src="{{ Storage::url($data_list->file_path) }}" class="rounded"
                                                        style="border:1px solid #ddd;" frameborder="0"
                                                        scrolling="auto"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Image Section --}}
                                    @if (!$data_list->file_path && $data_list->image_path)
                                        <div class="col-lg{{ $data_list->file_path ? '-12' : '-7' }}">
                                            <div class="card border-0 shadow-sm">
                                                <a href="{{ Storage::url($data_list->image_path) }}"
                                                    data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                                    title="{{ $data_list->title }}">
                                                    <img src="{{ Storage::url($data_list->image_path) }}"
                                                        class="img-fluid {{ $data_list->file_path ? 'w-25' : 'w-100' }}"
                                                        alt="{{ $data_list->title }}">
                                                </a>
                                            </div>
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
