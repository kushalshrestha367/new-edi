@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">

                        @if ($testPreparation)
                            <div class="row">
                                <div class="col-md">
                                    {{-- <img src="{{ $testPreparation->image_url }}" class="img-fluid w-50 float-start me-3 mb-2" alt="{{ $testPreparation->title }}"> --}}
                                    {!! $testPreparation->description !!}
                                </div>
                                @php
                                    $validPoints = collect($testPreparation->points)->filter(function ($item) {
                                        return !is_null($item) && $item !== '';
                                    });
                                @endphp
                                @if ($testPreparation->price || $validPoints->isNotEmpty() || $testPreparation->has_form)
                                    <div class="col-md-4 mb-3 ">

                                        @if ($testPreparation->price || $validPoints->isNotEmpty())
                                            <div class="card price mb-5">
                                                <div class="card-body">

                                                    {{-- Show price if available --}}
                                                    @if ($testPreparation->price)
                                                        <div>
                                                            <p class="text-center fst-italic">Price</p>
                                                            <h1 class="text-center">NRP {!! $testPreparation->price !!}</h1>
                                                            <p class="text-center fst-italic">Per Session</p>
                                                        </div>
                                                    @endif

                                                    {{-- Show filtered points --}}
                                                    @if ($validPoints->isNotEmpty())
                                                        <ul class="check-list list-unstyled p-2">
                                                            @foreach ($validPoints as $point)
                                                                <li>
                                                                    <i class="bi bi-check check-icon text-success"></i>
                                                                    <span>{{ $point }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                </div>
                                            </div>
                                        @endif

                                        @if ($testPreparation->has_form)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h2 class="text-center ">Enroll Now</h2>
                                                    <form id="form-submit">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name"
                                                                id="name" placeholder="Enter Your Name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="text" class="form-control" name="email"
                                                                id="email" placeholder="Enter Your Email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="contact" class="form-label">Contact No</label>
                                                            <input type="text" class="form-control" name="contact"
                                                                id="contact" placeholder="Enter Your Contact">
                                                        </div>
                                                        <input type="hidden" name="test_id" id="test_id"
                                                            value="{{ $testPreparation->id }}">

                                                        <button type="button" class="btn btn-primary"
                                                            id="submitBtn">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js-down')
    <script>
        $(document).ready(function() {
            $('#submitBtn').on('click', function() {
                const $btn = $(this);
                $btn.prop('disabled', true).text('Sending...');

                const formData = {
                    _token: "{{ csrf_token() }}",
                    name: $('#name').val(),
                    email: $('#email').val(),
                    contact: $('#contact').val(),
                    test_id: $('#test_id').val()
                };

                $.ajax({
                    url: "{{ route('send.email') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Email sent successfully!');
                        $('#form-submit')[0].reset();
                    },
                    error: function(xhr) {
                        alert('Error occurred while sending email.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>
@endpush
