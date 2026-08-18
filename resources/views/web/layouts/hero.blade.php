@if ($hero_section)
    <section id="aboutus"
        class="banner-section bg-gradient-shaph position-relative pt-15 pt-md-16 pb-11 pb-lg-12 pb-xl-0">
        @if ($hero_section->bg_image_left)
            <div class="position-absolute w-100 h-100">
                <img src="{{ Storage::url($hero_section->bg_image_left) }}"
                    class="img-fluid position-absolute bg-hero-left" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
            </div>
        @endif
        @if ($hero_section->bg_image_right)
            <div class="position-absolute w-100 h-100">
                <img src="{{ Storage::url($hero_section->bg_image_right) }}"
                    class="img-fluid position-absolute bg-hero-right" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
            </div>
        @endif
        <div class="container position-relative z-3 w-lg-75">
            <div class="d-flex flex-column gap-10">
                @if ($hero_section->institution_name || $hero_section->institution_short_name)
                    <h1 class="text-center mb-0" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                        {{ $hero_section->institution_name }}
                        @if ($hero_section->institution_short_name)
                            <em class="font-instrument fw-normal">{{ $hero_section->institution_short_name }}</em>
                        @else
                        <br><br>
                        @endif
                    </h1>
                @endif
                @if ($hero_section->description)
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200"
                        data-aos-duration="1000">
                        <div class="col-xl-7 text-center no-b-space">
                            {!! $hero_section->description !!}
                        </div>
                    </div>
                @endif
                <div class="d-md-flex align-items-center justify-content-center gap-10" data-aos="fade-up"
                    data-aos-delay="300" data-aos-duration="1000">
                    @if ($hero_section->cta_url)
                        <a href="{{ $hero_section->cta_url }}"
                            class="btn btn-primary py-md-8 pe-md-14 mx-auto mx-md-0 d-block d-md-flex">
                            <span class="btn-text">{{ $hero_section->cta_label }}</span>
                            <iconify-icon icon="solar:arrow-right-up-linear"
                                class="btn-icon bg-white text-dark round-32 rounded-circle hstack justify-content-center fs-6"></iconify-icon>
                        </a>
                    @endif
                    @if ($hero_section->video_url && $hero_section->show_video_button)
                        @php
                            preg_match(
                                '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]{11})/',
                                $hero_section->video_url,
                                $matches,
                            );
                            $videoId = $matches[1] ?? '';
                        @endphp
                        <div class="video-inner pt-4 pt-md-0">
                            <button class="play-btn" title="{{ $hero_section->video_title }}"
                                data-bs-toggle="modal" data-url="{{ $videoId }}" data-bs-target="#videoModal"
                                aria-label="Play campus video">
                                <i class="fa fa-play"></i>
                                <i class="bi bi-play-fill"></i>
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="videoModal" tabindex="-1" aria-label="Campus video">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="ratio ratio-16x9">
                    <iframe id="ytPlayer" src=""
                        title="{{ $hero_section->institution_short_name ?? $hero_section->institution_name }}"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
@endif
