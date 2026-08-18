@extends('web.layouts.app')

@push('css')
@endpush

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container pb-6">
                        <div class="row">
                            <div class="col-md mx-auto">
                                @if ($itemData->image_url)
                                    <img src="{{ $itemData->image_url }}"
                                        class="img-fluid w-50 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $itemData->title }}">
                                @endif

                                <h2 class="fw-bold mb-3" style="letter-spacing: 1px;">
                                    {{ $itemData->title }}
                                </h2>

                                @if ($itemData->created_at)
                                    <span class="d-flex flex-wrap gap-2 align-items-center" title="Publish At">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>
                                            @if ($itemData->created_at)
                                                {{ date('d M Y', strtotime($itemData->created_at)) }}
                                            @endif
                                        </span>

                                    </span>
                                @endif

                                @if ($itemData->description)
                                    <div class="mt-2">
                                        {!! $itemData->description !!}
                                    </div>
                                @endif

                                @if (!empty($itemData->experience))
                                    <div class="mt-3">
                                        <h6 class="fw-bold mb-3">Experience</h6>

                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($itemData->experience as $exp)
                                                <span class="badge bg-light border text-dark p-2">
                                                    <strong>{{ $exp['title'] }}</strong>
                                                    <span class="text-muted ms-2">{{ $exp['duration'] }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="col-md-4">
                                <div class="p-4 rounded-3 bg-light border position-sticky" style="top: 100px;">

                                    <h6 class="fw-bold mb-3">
                                        Overview
                                    </h6>
                                    @if ($itemData->short_description)
                                        <div class="small mb-4">
                                            {!! $itemData->short_description !!}
                                        </div>
                                    @endif

                                    @if ($itemData->department)
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2" title="Department">
                                                <i class="text-web-primary fa-solid fa-building"></i>
                                                <span class="fw-medium">{{ $itemData->department }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($itemData->location)
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2" title="Location/Address">
                                                <i class="text-web-primary fa-solid fa-location-dot"></i>
                                                <span class="fw-medium">{{ $itemData->location }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($itemData->job_type)
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2" title="Job Type">
                                                <i class="text-web-primary fa-solid fa-briefcase"></i>
                                                <span class="fw-medium">{{ $itemData->job_type }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($itemData->salary)
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2" title="Salary">
                                                <i class="text-web-primary fa-solid fa-sack-dollar"></i>
                                                <span class="fw-medium">Salary: {{ $itemData->salary }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($itemData->vacancies)
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2" title="Vacancies">
                                                <i class="text-web-primary fa-solid fa-user-group"></i>
                                                <span class="fw-medium">Vacancies: {{ $itemData->vacancies }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-2" title="Applicants">
                                            <i class="text-web-primary fa-solid fa-users"></i>
                                            <span class="fw-medium">
                                                Participants: {{ $itemData->applications->count() }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center gap-2" title="Deadline">
                                            <i class="text-web-primary fa-solid fa-calendar-days"></i>
                                            <span class="fw-medium">
                                                Deadline: {{ date('d M Y', strtotime($itemData->deadline)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <button type="button" id="enableForm"
                                        class="btn btn-primary py-md-6 pe-md-12 mx-auto mx-md-0 d-block d-md-flex w-100">
                                        <span class="btn-text">Submit Application</span>
                                        <iconify-icon icon="solar:arrow-right-up-linear"
                                            class="btn-icon bg-white text-dark round-32 rounded-circle hstack justify-content-center fs-6"></iconify-icon>
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <form action="{{ route('career.form.apply', $itemData->slug) }}" method="POST"
                                enctype="multipart/form-data" id="applicationForm" class="d-none">
                                @csrf
                                <div class="col-md-8 mx-auto">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <h4 class="fw-bold mb-4 text-uppercase">Apply for {{ $itemData->title }}</h4>
                                            <div class="mb-3">
                                                <label for="name" class="form-label fw-medium">Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-medium">Email Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="form-label fw-medium">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="resume_path" class="form-label fw-medium">Upload CV <span
                                                        class="text-danger">* <small>Only PDF files. Max
                                                            2MB.</small></span></label>
                                                <input type="file" class="form-control" id="resume_path"
                                                    name="resume_path" accept="application/pdf" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cover_letter" class="form-label fw-medium">Cover Letter /
                                                    Message
                                                </label>
                                                <textarea class="form-control" id="cover_letter" name="cover_letter" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0 text-end">
                                            <button type="button" class="btn btn-primary" id="submitApply">
                                                Submit Application
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if ($itemDataRelated->isNotEmpty())
                            <div class="mt-5">
                                <h4 class="fw-bold mb-4 text-uppercase">Other Downloads</h4>

                                <div class="list-group">
                                    @foreach ($itemDataRelated as $index => $item)
                                        <div class="col-md-12 mb-4">
                                            <div class="card h-100 shadow-sm border-0 career-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                                        <div>
                                                            <h5 class="fw-bold mb-2">
                                                                {{ $item->title }}
                                                            </h5>

                                                            <div class="text-muted small">
                                                                <span class="me-3">
                                                                    <i class="bi bi-building me-1"></i>
                                                                    {{ $item->department }}
                                                                </span>
                                                                <span class="me-3">
                                                                    <i class="bi bi-geo-alt me-1"></i>
                                                                    {{ $item->location }}
                                                                </span>
                                                                <span class="me-3">
                                                                    <i class="bi bi-briefcase me-1"></i>
                                                                    {{ $item->job_type }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="text-end">
                                                            <span class="badge bg-primary text-uppercase">
                                                                {{ $item->job_type }}
                                                            </span>
                                                        </div> --}}
                                                    </div>

                                                    <div
                                                        class="d-flex flex-wrap justify-content-between align-items-center mt-2">
                                                        <div class="text-muted small">
                                                            <span class="me-3">
                                                                <i class="bi bi-person-lines-fill me-1"></i>
                                                                Vacancies: {{ $item->vacancies }}
                                                            </span>

                                                            <span class="me-3">
                                                                <i class="bi bi-calendar-event me-1"></i>
                                                                Deadline: {{ date('d M Y', strtotime($item->deadline)) }}
                                                            </span>
                                                        </div>

                                                        <a href="{{ route('career.item.detail', $item->slug) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $('#enableForm').on('click', function() {
            $('#applicationForm').removeClass('d-none');
            $('html, body').animate({
                scrollTop: $("#applicationForm").offset().top - 100
            }, 500);
        });

        $('#submitApply').on('click', function() {
            // $('#applicationForm').submit();
            $.ajax({
                url: $('#applicationForm').attr('action'),
                type: 'POST',
                data: new FormData($('#applicationForm')[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Application submitted successfully!');
                    $('#applicationForm')[0].reset();
                },
                error: function(xhr) {
                    alert('An error occurred while submitting your application. Please try again.');
                }
            });
        });
    </script>
@endpush
