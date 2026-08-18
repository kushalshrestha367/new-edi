@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">

                                <h2 class="text-uppercase mb-3">{{ $whyChooseUs->title }}</h2>
                                @if ($whyChooseUs->image_url)
                                    <img src="{{ $whyChooseUs->image_url }}"
                                        class="img-fluid w-25 mb-2 ms-2 rounded shadow float-end"
                                        alt="{{ $whyChooseUs->title }}">
                                @endif
                                <div class="detail-table-main">
                                    {!! $whyChooseUs->description !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js-down')
    <script>
        $(document).ready(function() {
            $('.detail-table-main table').addClass('table table-bordered table-striped');

            $('.detail-table-main thead').addClass('table-primary');

            $('.detail-table-main table').each(function() {
                const $table = $(this);

                if ($table.find('thead').length === 0) {
                    $table.find('tbody').each(function() {
                        $(this).find('tr').first().addClass('bg-dark text-white');
                    });
                }
            });
        });
    </script>
@endpush
