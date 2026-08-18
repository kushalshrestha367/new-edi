@extends('web.layouts.app')

@push('css')
    {{-- Original EDI Homes CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Original Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
@endpush

@section('content')

    <!-- =========================================
         DESIGN & PLANNING PAGE
         Paste the original page CONTENT here
         ========================================= -->

    <!-- HERO -->
    <section class="py-5" style="background-color: #eef4f9">
        <div class="container py-5">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">

                    <span
                        class="badge rounded-pill px-3 py-2 mb-3"
                        style="background-color: #dceaf5; color: #16324f"
                    >
                        DESIGN &amp; PLANNING
                    </span>

                    <h1
                        class="display-4 fw-bold mb-4"
                        style="color: #16324f"
                    >
                        Plan With Purpose.
                        <span style="color: #4a7fb0">
                            Build With Confidence.
                        </span>
                    </h1>

                    <p class="lead text-secondary mb-4">
                        Thoughtful design and organised planning give your
                        project a stronger foundation before construction begins.
                    </p>

                    <div class="d-flex flex-wrap gap-3">

                        <a
                            href="{{ route('welcome') }}#enquiry"
                            class="btn btn-primary btn-lg rounded-pill px-4"
                        >
                            Discuss Your Project
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                        <a
                            href="{{ route('welcome') }}#projects"
                            class="btn btn-outline-dark btn-lg rounded-pill px-4"
                        >
                            View Projects
                        </a>

                    </div>

                </div>

                <div class="col-lg-6">

                    <img
                        src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="Design and planning"
                    >

                </div>

            </div>
        </div>
    </section>


    <!-- INTRODUCTION -->
    <section class="py-5">

        <div class="container py-5">

            <div class="row justify-content-center text-center">

                <div class="col-lg-8">

                    <span
                        class="fw-semibold text-uppercase"
                        style="color: #4a7fb0"
                    >
                        Design &amp; Planning
                    </span>

                    <h2
                        class="display-6 fw-bold mt-2 mb-4"
                        style="color: #16324f"
                    >
                        A Stronger Start For Your Project
                    </h2>

                    <p class="lead text-secondary">
                        Good planning creates clarity before construction begins.
                        We help bring your ideas together into a practical and
                        considered project direction.
                    </p>

                    <p class="text-secondary">
                        From understanding your requirements to preparing for
                        construction, EDI Homes helps create a more organised
                        path forward.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- WHY EDI HOMES -->
    <section
        class="py-5"
        style="
            background: linear-gradient(
                135deg,
                #eef4f9 0%,
                #f8fbfd 100%
            );
        "
    >

        <div class="container py-5">

            <div class="text-center mb-5">

                <span
                    class="fw-semibold text-uppercase"
                    style="color: #4a7fb0"
                >
                    Why EDI Homes
                </span>

                <h2
                    class="display-6 fw-bold mt-2 mb-3"
                    style="color: #16324f"
                >
                    Plan With Confidence
                </h2>

                <p
                    class="text-secondary mx-auto"
                    style="max-width: 650px"
                >
                    Thoughtful preparation helps establish clearer expectations
                    and a stronger foundation for construction.
                </p>

            </div>

            <div class="row g-4">

                <div class="col-md-6 col-lg-3">

                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                        <i
                            class="bi bi-lightbulb fs-2"
                            style="color: #4a7fb0"
                        ></i>

                        <h4
                            class="fw-bold mt-4"
                            style="color: #16324f"
                        >
                            Clear Direction
                        </h4>

                        <p class="text-secondary mb-0">
                            Understand your project goals and establish a
                            clearer direction from the beginning.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                        <i
                            class="bi bi-pencil-square fs-2"
                            style="color: #4a7fb0"
                        ></i>

                        <h4
                            class="fw-bold mt-4"
                            style="color: #16324f"
                        >
                            Thoughtful Design
                        </h4>

                        <p class="text-secondary mb-0">
                            Develop ideas around your lifestyle, requirements
                            and the opportunities of your site.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                        <i
                            class="bi bi-file-earmark-check fs-2"
                            style="color: #4a7fb0"
                        ></i>

                        <h4
                            class="fw-bold mt-4"
                            style="color: #16324f"
                        >
                            Better Preparation
                        </h4>

                        <p class="text-secondary mb-0">
                            Organise the requirements and information needed
                            before construction begins.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                        <i
                            class="bi bi-building-check fs-2"
                            style="color: #4a7fb0"
                        ></i>

                        <h4
                            class="fw-bold mt-4"
                            style="color: #16324f"
                        >
                            Strong Foundation
                        </h4>

                        <p class="text-secondary mb-0">
                            Create a stronger foundation for the construction
                            stage and your path toward completion.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- PROCESS -->
    <section class="py-5">

        <div class="container py-5">

            <div class="text-center mb-5">

                <span
                    class="fw-semibold text-uppercase"
                    style="color: #4a7fb0"
                >
                    Our Process
                </span>

                <h2
                    class="display-6 fw-bold mt-2"
                    style="color: #16324f"
                >
                    From Idea To Clear Direction
                </h2>

            </div>

            <div class="row g-4">

                <div class="col-md-6 col-lg-3">

                    <div class="text-center">

                        <div
                            class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                            style="
                                width: 55px;
                                height: 55px;
                                background-color: #4a7fb0;
                            "
                        >
                            01
                        </div>

                        <h5 class="fw-bold">
                            Consultation
                        </h5>

                        <p class="text-secondary">
                            Discuss your vision, requirements and project goals.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="text-center">

                        <div
                            class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                            style="
                                width: 55px;
                                height: 55px;
                                background-color: #4a7fb0;
                            "
                        >
                            02
                        </div>

                        <h5 class="fw-bold">
                            Planning
                        </h5>

                        <p class="text-secondary">
                            Establish the project direction and requirements.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="text-center">

                        <div
                            class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                            style="
                                width: 55px;
                                height: 55px;
                                background-color: #4a7fb0;
                            "
                        >
                            03
                        </div>

                        <h5 class="fw-bold">
                            Documentation
                        </h5>

                        <p class="text-secondary">
                            Prepare the information and documentation needed.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="text-center">

                        <div
                            class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                            style="
                                width: 55px;
                                height: 55px;
                                background-color: #4a7fb0;
                            "
                        >
                            04
                        </div>

                        <h5 class="fw-bold">
                            Construction Ready
                        </h5>

                        <p class="text-secondary">
                            Build a stronger foundation for the next stage.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- CTA -->
    <section
        class="py-5"
        style="background-color: #16324f"
    >

        <div class="container py-5 text-center">

            <span
                class="fw-semibold text-uppercase text-white"
            >
                Start Your Project
            </span>

            <h2 class="display-6 fw-bold text-white mt-2 mb-3">
                Let's Plan Your Future Home
            </h2>

            <p
                class="text-white-50 mx-auto mb-4"
                style="max-width: 650px"
            >
                Talk to EDI Homes about your vision and take the first step
                toward a clear project direction.
            </p>

            <a
                href="{{ route('welcome') }}#enquiry"
                class="btn btn-light btn-lg rounded-pill px-5"
            >
                Make an Enquiry
                <i class="bi bi-arrow-right ms-2"></i>
            </a>

        </div>

    </section>

@endsection