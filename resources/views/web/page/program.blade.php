@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($programDatas->isNotEmpty())
                        <div class="container py-6">
                            <div class="d-flex flex-column align-items-center mb-6">
                                <div class="nav nav-pills p-1 bg-light rounded-pill border" id="pills-tab" role="tablist">
                                    @foreach ($programDatas as $key => $c_element)
                                        <button class="nav-link rounded-pill px-4 py-2 {{ $key == 0 ? 'active' : '' }}"
                                            data-bs-toggle="pill" data-bs-target="#tab-{{ $key }}">
                                            {!! $c_element->title !!}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-content">
                                @foreach ($programDatas as $key => $p_list)
                                    <div class="tab-pane mt-4 fade {{ $key == 0 ? 'show active' : '' }}"
                                        id="tab-{{ $key }}">
                                        <div class="row g-4 justify-content-center">
                                            @foreach ($p_list->programs as $pc_listed)
                                                <div class="col-md-6 col-lg-4">
                                                    <a href="{{ route('program.item.detail', $pc_listed->slug) }}"
                                                        class="text-decoration-none group">
                                                        <div class="card h-100 border-1 border-light shadow-sm rounded-4 hover-lift">
                                                            <div class="card-body p-4 d-flex align-items-center">
                                                                <div
                                                                    class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-4">
                                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-bold text-dark mb-1">
                                                                        {{ $pc_listed->title }}</h6>
                                                                    <small class="text-muted">Learn more →</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <style>
                            /* Professional Refinements */
                            
                        </style>
                    @else
                        @include('web.layouts.404')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
