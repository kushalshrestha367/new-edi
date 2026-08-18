@php
    use Outerweb\ImageLibrary\Models\Image;

    $image = Image::find($state);
@endphp

@if ($image)
    <div class="flex justify-center mt-2">
        <img src="{{ $image->getUrl('filament-thumbnail') }}"
             alt="Preview"
             class="w-32 h-32 rounded-full object-cover shadow border" />
    </div>
@endif
