@extends('web.layouts.app')

@section('content')

    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    @if ($departmentData->isNotEmpty())
                        @foreach ($departmentData as $department)
                            <div class="container-fluid">
                                <div class="container">
                                    <div class="row g-4 mb-5">
                                        <h2>{{ $department->title }}</h2>

                                        @foreach ($department->items->take(6) as $departmentitem)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="position-relative rounded overflow-hidden shadow-sm border-0">
                                                    <div>
                                                        <img src="{{ $departmentitem->image_url ?? asset('images/no-file.jpg') }}"
                                                            class="img-fluid w-100 service-img"
                                                            alt="{{ $departmentitem->title }}">
                                                    </div>
                                                    <div class="text-center bg-primary">
                                                        <a href="{{ route('department.item.detail', [$department->slug, $departmentitem->slug]) }}"
                                                            class="text-decoration-none service-item">
                                                            <h5 class="text-uppercase text-white py-2 mb-0">
                                                                {{ $departmentitem->title }}
                                                            </h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="text-center">
                                            <a href="{{ route('department.detail', [$department->slug]) }}"
                                                class="text-decoration-none">
                                                <button type="button" class="btn btn-primary">Explore</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
