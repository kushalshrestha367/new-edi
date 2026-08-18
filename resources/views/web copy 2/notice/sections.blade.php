@if ($notice_list_data->isNotEmpty())
    <section id="noticeboard">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right">
                    <div class="section-eyebrow">Latest Updates</div>
                    <h2 class="section-title mb-3">Notice <em class="font-instrument">Board</em></h2>
                    <p class="section-sub mb-4">Stay informed about admissions, examinations, events, and
                        important
                        announcements from {{ $site_title ?? config('app.name', 'Saffron Infosys Pvt. Ltd.') }}.</p>
                    <div class="d-md-flex align-items-center mt-10" data-aos="fade-up" data-aos-delay="300"
                        data-aos-duration="1000">
                        <a href="{{ route('notice.latest.list') }}"
                            class="btn btn-primary py-md-6 pe-md-13 mx-auto mx-md-0 d-block d-md-flex">
                            <span class="btn-text">View All Notices</span>
                            <iconify-icon icon="solar:arrow-right-up-linear"
                                class="btn-icon bg-white text-dark round-32 rounded-circle hstack justify-content-center fs-6"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    @forelse ($notice_list_data as $nlelement)
                        @php
                            $date = \Carbon\Carbon::parse($nlelement->date_show ?? $nlelement->created_at);
                            $isNew = $date->diffInDays(now()) < 5;
                        @endphp

                        <div data-aos="fade-up" data-aos-delay="50">
                            <div class="notice-card">
                                <div class="notice-date-box">
                                    <div class="day">{{ $date->format('d') }}</div>
                                    <div class="mon">{{ $date->format('M') }}</div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        @if ($isNew)
                                            <span class="notice-badge nb-new">New</span>
                                        @endif
                                        
                                        <span class="notice-badge nb-{{ strtolower($nlelement->type ?? 'general') }}">
                                            {{ ucfirst($nlelement->type ?? 'Notice') }}
                                        </span>
                                    </div>

                                    <div class="notice-title">
                                        <a href="{{ route('notice.detail', $nlelement->slug) }}">
                                            {!! $nlelement->title !!}
                                        </a>
                                    </div>

                                    <div class="notice-meta">
                                        <span>
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ date('M d, Y', strtotime($nlelement->date_show ?? $nlelement->created_at)) }}
                                            -
                                            <i>
                                                {!! $date->diffInDays(now()) < 5 ? $date->diffForHumans() : $date->format('Y') ?? $nlelement->date_show !!}
                                            </i>
                                        </span>
                                        |
                                        @if ($nlelement->file_path)
                                            <a href="{{ Storage::url($nlelement->file_path) }}"
                                                target="_blank">
                                                <i class="far fa-file-alt me-1"></i> View File
                                            </a>
                                        @endif
                                        @if ($nlelement->image_path)
                                            <a href="{{ Storage::url($nlelement->image_path) }}"
                                                target="_blank">
                                                <i class="far fa-file-image me-1"></i> View Image
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No notices available at the moment.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endif
