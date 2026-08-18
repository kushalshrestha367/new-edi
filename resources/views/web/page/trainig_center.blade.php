@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container-fluid pb-4">
                        <div class="container">
                            <div class="row align-items-center g-5">
                                @if ($trainingCenters)
                                    <div class=" wow fadeIn" data-wow-delay="0.3s">
                                        <h1 class="display-6 text-uppercase mb-4 text-center">{{ $trainingCenters->title }}
                                        </h1>
                                        @if ($trainingCenters->image_url)
                                            <img class="img-fluid rounded w-50 me-3 mb-2 float-start"
                                                src="{{ $trainingCenters->image_url }}" alt="{{ $trainingCenters->title }}">
                                        @endif
                                        <div class="wow fadeIn" data-wow-delay="0.5s">
                                            @if ($trainingCenters->description)
                                                <div class="about-description">
                                                    {!! $trainingCenters->description !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
