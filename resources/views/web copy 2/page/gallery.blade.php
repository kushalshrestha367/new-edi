@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">
                    @if ($galleryFolder->isNotEmpty())
                        <div class="container">
                            <div class="row g-4">
                                @foreach ($galleryFolder as $folder)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <a href="{{ route('gallery.item.detail', $folder->slug) }}">
                                            <div class="folder-stack position-relative card-hover" style="height:200px;">
                                                @if ($folder->images->count())
                                                    @foreach ($folder->images->where('is_active', true)->take(2) as $index => $img)
                                                        <img src="{{ Storage::url($img->image_path) }}"
                                                            style="position:absolute; top:{{ $index * 8 }}px; left:{{ $index * 8 }}px; width:100%; height:180px; object-fit:cover; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
                                                    @endforeach
                                                @else
                                                    <i
                                                        class="bi bi-folder-fill fs-1 text-warning position-absolute top-50 start-50 translate-middle"></i>
                                                @endif
                                                <div
                                                    class="position-absolute bottom-0 start-0 w-100 text-center bg-white py-2 rounded-bottom shadow">
                                                    <h6 class="fw-bold mb-0">{{ $folder->title }}</h6>
                                                    <small
                                                        class="text-muted">{{ $folder->images->where('is_active', true)->count() }}
                                                        {{ Str::plural('Image', $folder->images->count()) }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $galleryFolder->links() }}
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
