@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb-detail')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">


                                <ul class="list-unstyled text-muted">
                                    @if ($contactBranchData->address)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Address:</strong>
                                                {{ $contactBranchData->address }}</span>
                                        </li>
                                    @endif

                                    @if ($contactBranchData->phone)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-phone-alt text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Phone:</strong>
                                                {{ $contactBranchData->phone }}</span>
                                        </li>
                                    @endif

                                    @if ($contactBranchData->fax)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-fax text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Fax:</strong>
                                                {{ $contactBranchData->fax }}</span>
                                        </li>
                                    @endif

                                    @if ($contactBranchData->email)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                            <span><strong class="text-dark">Email:</strong>
                                                {{ $contactBranchData->email }}</span>
                                        </li>
                                    @endif
                                </ul>

                            </div>

                            <div class="col-md-6">
                                @if ($contactBranchData->latitude && $contactBranchData->longitude)
                                    <div class="ratio ratio-16x9 shadow rounded"
                                        style="max-height: 300px; overflow: hidden;">
                                        <iframe
                                            src="https://maps.google.com/maps?q={{ $contactBranchData->latitude }},{{ $contactBranchData->longitude }}&z=15&output=embed"
                                            width="100%" height="100%" style="border:0;" allowfullscreen=""
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
