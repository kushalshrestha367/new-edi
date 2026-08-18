@extends('web.layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ url('web') }}/css/timeline.web.css">
@endpush
@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">
                    <div class="container">
                        <div class="notice-list">
                            @foreach ($data_lists as $element)
                                <div class="notice-item wow fadeInUp" data-wow-delay="0.{{ $loop->index + 1 }}s">
                                    <div class="float-end">
                                        @if ($element->doc_file_path)
                                            <a href="{{ url($element->doc_file_path) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download"></i>
                                                download
                                            </a>
                                        @endif
                                    </div>
                                    <a href="{{ route('notice.detail', $element->slug) }}" class="notice-main-content">
                                        <h5 class="mb-1 text-dark fw-semibold">
                                            @if ($element->file_path)
                                                <i class="far fa-images me-2 text-primary"></i>
                                            @endif
                                            {!! $element->title !!}
                                        </h5>
                                        @if ($element->date_show)
                                            <small class="text-muted">
                                                {!! $element->date_show !!}
                                            </small>
                                        @else
                                            <small class="text-muted">
                                                {{ date_create($element->created_at)->format('M') }}
                                                {{ date_create($element->created_at)->format('d') }},
                                                {{ date_create($element->created_at)->format('Y') }}
                                            </small>
                                        @endif
                                        @if ($element->description || $element->description != '<p>.</p>')
                                            <p class="mb-0 text-muted text-end">
                                                {!! Str::limit(strip_tags($element->description), 120) !!}
                                            </p>
                                        @endif
                                    </a>

                                </div>
                            @endforeach
                        </div>

                        @if ($data_lists->hasPages())
                            <div class="mt-4 d-flex justify-content-center">
                                {!! $data_lists->links() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
