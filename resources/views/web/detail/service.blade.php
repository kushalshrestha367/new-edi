@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container pb-6">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                @if ($serviceItemData->image_url)
                                    <img src="{{ $serviceItemData->image_url }}"
                                        class="img-fluid w-50 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $serviceItemData->title }}">
                                @endif

                                {{-- <h2 class="text-uppercase mb-3">{{ $serviceItemData->title }}</h2> --}}
                                <div>
                                    {!! $serviceItemData->description !!}
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
