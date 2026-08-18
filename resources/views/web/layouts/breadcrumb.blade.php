<div class="d-flex flex-column gap-10 gap-lg-12 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <h2 class="display-6 fw-semibold text-center" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                {{ @$pageName }}
            </h2>
            @if (@$subPageName)
                <h3 class="text-center" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1200">
                    <em class="font-instrument">{{ @$subPageName }}</em>
                </h3>
            @endif
        </div>
    </div>
</div>
