@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md mx-auto">
                                @if ($programItemData->image_url)
                                    <img src="{{ $programItemData->image_url }}"
                                        class="img-fluid w-50 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $programItemData->title }}">
                                @endif

                                {{-- <h4 class="text-uppercase mb-3">{{ $programItemData->title }}</h4> --}}

                                <div>
                                    {!! $programItemData->description !!}
                                </div>
                            </div>
                            @if ($programItemData->activeFiles()->count())
                                <div class="col-md-4">
                                    <div class="p-4 rounded-3 bg-light border position-sticky" style="top: 100px;">

                                        {{-- <h6 class="fw-bold mb-3">
                                            📄 Program Files
                                        </h6> --}}

                                        <div class="small mb-4">
                                            {!! $programItemData->short_description !!}
                                        </div>

                                        @foreach ($programItemData->activeFiles as $item)
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
