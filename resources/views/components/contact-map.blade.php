{{-- @php
    $lat = old('data.latitude') ?? data_get($getRecord(), 'latitude') ?? 26.464791;
    $lng = old('data.longitude') ?? data_get($getRecord(), 'longitude') ?? 87.280825;
@endphp

<iframe
  src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&t=k&z=15&markers={{ $lat }},{{ $lng }}&output=embed"
  width="100%" height="450" frameborder="0" style="border:0" allowfullscreen>
</iframe> --}}

<iframe
    src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&t=k&z=15&output=embed"
    width="100%" height="450" frameborder="0" style="border:0" allowfullscreen>
</iframe>
