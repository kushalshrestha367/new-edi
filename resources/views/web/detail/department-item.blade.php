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

                                @if ($department->image_url)
                                    <img src="{{ $department->image_url }}"
                                        class="img-fluid w-25 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $department->title }}">
                                @endif

                                {{-- <h2 class="text-uppercase mb-3">{{ $department->title }}</h2> --}}
                                <div>
                                    {!! $department->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($department && $department->members->isNotEmpty())
                        <div class="container-xxl pt-5">
                            <div class="container">
                                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                    <h6 class="text-secondary text-uppercase">Our Member</h6>
                                    <h1 class="mb-5">Our Expert</h1>
                                </div>
                                <div class="row g-4">
                                    @foreach ($department->members as $member)
                                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                            <div class="team-item">
                                                <div class="position-relative overflow-hidden">
                                                    <img class="img-fluid w-100 team-img" src="{{ $member->image_url }}"
                                                        alt="{{ $member->name }}">
                                                </div>
                                                <div class="team-text">
                                                    <div class="bg-light">
                                                        <h5 class="fw-bold mb-0">{{ $member->name }}</h5>
                                                        @if (!empty($member->designation))
                                                            <small>{{ $member->designation }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="bg-primary">
                                                        @if (!empty($member->nmc_number))
                                                            <span class="text-white mx-1">
                                                                NMC: {{ $member->nmc_number }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
