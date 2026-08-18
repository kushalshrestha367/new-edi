@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">
                    @if ($faqDatas->isNotEmpty())
                    <div class="container mb-5">
                        <div class="accordion" id="faqAccordion">
                            @forelse ($faqDatas as $key => $element)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $key + 1 }}">
                                        <button class="accordion-button {{ $key + 1 == '1' ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq{{ $key + 1 }}">
                                            {{ $element->question }}
                                        </button>
                                    </h2>
                                    <div id="faq{{ $key + 1 }}"
                                        class="accordion-collapse collapse {{ $key + 1 == '1' ? ' show' : '' }}"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {!! $element->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                    @else
                    @include('web.layouts.404')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
