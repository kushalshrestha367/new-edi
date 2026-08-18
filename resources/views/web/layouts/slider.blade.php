@if ($site_slider->isNotEmpty())
<div class="container-fluid p-0">
    <div class="owl-carousel header-carousel position-relative">
        @foreach ($site_slider->sortBy('sort_order') as $key => $slider)
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid web-slider" src="{{ $slider->image_url }}" alt="{!! $slider->slider_title !!}">
            @if ($slider->title)
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .4);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-10 col-lg-8">
                            @if ($slider->subtitle && strlen($slider->subtitle) < 40)
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">
                                {{ $slider->subtitle }}
                            </h5>
                            @endif
                            <h1 class="display-5 text-white animated slideInDown mb-4">{{ $slider->title }}</h1>
                            @if ($slider->subtitle && strlen($slider->subtitle) > 40)
                            <p class="fs-5 fw-medium text-white mb-4 pb-2">
                                {{ $slider->subtitle }}
                            </p>
                            @endif
                            @if ($slider->btn1_name && $slider->btn1_link)
                            <a href="{{ $slider->btn1_link }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{ $slider->btn1_name }}</a>
                            @endif
                            @if ($slider->btn2_name && $slider->btn2_link)
                            <a href="{{ $slider->btn2_link }}" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">{{ $slider->btn2_name }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif
