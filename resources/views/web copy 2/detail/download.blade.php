@extends('web.layouts.app')

@push('css')
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

                                <h2 class="fw-bold mb-3" style="letter-spacing: 1px;">
                                    {{ $itemData->title }}
                                </h2>

                                @if ($itemData->created_at)
                                    <span class="d-flex flex-wrap gap-2 align-items-center">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>
                                            @if ($itemData->created_at)
                                                {{ date('d M Y', strtotime($itemData->created_at)) }}
                                            @endif
                                        </span>

                                    </span>
                                @endif

                                {{-- @if ($itemData->short_description)
                    <div class="my-4 p-4 bg-light border-start border-4 border-secondary rounded">
                        <div class="short-description text-muted lh-lg">
                            {!! $itemData->short_description !!}
                        </div>
                    </div>
                @endif --}}

                                @if ($itemData->description)
                                    <div class="mt-2">
                                        {!! $itemData->description !!}
                                    </div>
                                @endif
                            </div>

                            @if ($itemData->files()->count())
                                <div class="col-md-4">
                                    <div class="p-4 rounded-3 bg-light border position-sticky" style="top: 100px;">

                                        {{-- <h6 class="fw-bold mb-3">
                            📄 Download Files
                        </h6> --}}

                                        <div class="small mb-4">
                                            {!! $itemData->short_description !!}
                                        </div>

                                        @foreach ($itemData->files->where('is_active', true) as $item)
                                            <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                                class="d-flex align-items-center justify-content-between mb-3 text-decoration-none">

                                                <div class="d-flex align-content-start gap-2">
                                                    <span class="mt-1">
                                                        @switch(strtolower($item->file_type))
                                                            @case('jpg')
                                                            @case('jpeg')

                                                            @case('png')
                                                            @case('gif')
                                                                <i class="fas fa-lg fa-file-image text-success"></i>
                                                            @break

                                                            @case('pdf')
                                                                <i class="fas fa-lg fa-file-pdf text-danger"></i>
                                                            @break

                                                            @case('doc')
                                                            @case('docx')
                                                                <i class="fas fa-lg fa-file-word text-primary"></i>
                                                            @break

                                                            @case('xls')
                                                            @case('xlsx')
                                                                <i class="fas fa-lg fa-file-excel text-success"></i>
                                                            @break

                                                            @case('ppt')
                                                            @case('pptx')
                                                                <i class="fas fa-lg fa-file-powerpoint text-warning"></i>
                                                            @break

                                                            @case('mp4')
                                                            @case('avi')

                                                            @case('mov')
                                                                <i class="fas fa-lg fa-file-video text-info"></i>
                                                            @break

                                                            @default
                                                                <i class="fas fa-lg fa-file-alt text-muted"></i>
                                                        @endswitch
                                                    </span>

                                                    <span class="fw-medium">{{ $item->file_name }}</span>
                                                </div>

                                                {{-- <i class="fas fa-download text-muted"></i> --}}
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                            @endif

                        </div>

                        @if ($itemDataRelated->isNotEmpty())
                            <div class="mt-5">
                                <h4 class="fw-bold mb-4 text-uppercase">Other Downloads</h4>

                                <div class="list-group">
                                    @foreach ($itemDataRelated as $item)
                                        <a href="{{ route('download.item.detail', $item->slug) }}"
                                            class="list-group-item list-group-item-action d-flex align-items-center justify-content-between gap-3 py-3">

                                            <div class="d-flex align-items-center gap-3">
                                                <div class="download-icon d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-file-earmark-arrow-down fs-3 text-primary"></i>
                                                </div>

                                                <div>
                                                    <h6 class="mb-1 fw-semibold line-clamp-2">
                                                        {{ $item->title }}
                                                    </h6>
                                                    <small class="text-muted">Click to view or download</small>
                                                </div>
                                            </div>

                                            <span class="btn btn-sm btn-outline-primary">
                                                Download
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
