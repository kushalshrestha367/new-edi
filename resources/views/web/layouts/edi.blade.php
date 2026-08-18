<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $title ?? 'EDI Homes — Building Your Future' }}
    </title>

    <meta
        name="description"
        content="EDI Homes is a residential and commercial construction company delivering considered, well-built homes from first sketch to final handover."
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    >

    @stack('css-top')
    @stack('css')

    @livewireStyles
</head>

<body>

    @yield('content')

    @stack('js-top')
    @stack('js')
    @stack('js-down')

    @livewireScripts

</body>
</html>