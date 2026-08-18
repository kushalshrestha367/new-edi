@php
    $lat = data_get($getRecord(), 'latitude') ?? 27.7172;
    $lng = data_get($getRecord(), 'longitude') ?? 85.3240;
@endphp

<div id="branch-map-{{ $getId() }}" style="height: 300px;"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mapId = "branch-map-{{ $getId() }}";
        const lat = parseFloat(@json($lat));
        const lng = parseFloat(@json($lng));

        const map = new google.maps.Map(document.getElementById(mapId), {
            center: { lat: lat, lng: lng },
            zoom: 14,
        });

        new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
        });
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3mqgQda-v1B5Qg5Jhsr57igbgTOqtTwU"></script>
