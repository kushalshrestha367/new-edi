@extends('web.layouts.app')

@section('content')

    {{-- EDI New Home Builds UI --}}

    <section class="py-5" style="background-color: #eef4f9;">
        <div class="container py-5">

            <div class="row align-items-center g-5">

                <div class="col-lg-6">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                          style="background-color:#dceaf5;color:#16324f;">
                        NEW HOME BUILDS
                    </span>

                    <h1 class="display-4 fw-bold mb-4"
                        style="color:#16324f;">
                        Build the Home.
                        <span style="color:#4a7fb0;">
                            You've Imagined.
                        </span>
                    </h1>

                    <p class="lead text-secondary mb-4">
                        From the first idea to the final handover,
                        EDI Homes helps bring your vision to life.
                    </p>

                    <a href="{{ route('welcome') }}#enquiry"
                       class="btn btn-primary btn-lg rounded-pill px-4">
                        Start Your Project
                    </a>

                </div>

                <div class="col-lg-6">

                    <img
                        src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="Modern new home"
                    >

                </div>

            </div>

        </div>
    </section>

@endsection