<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bina Desa | {{ $title ?? 'Login' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- CSS Bawaan Template (Bootstrap, FontAwesome, dll) --}}
    @include('layouts_admin.css')
</head>

<body>
    <div id="loading">
        <div id="loading-center"></div>
    </div>

    {{-- Konten Login akan dimuat di sini --}}
    @yield('konten')

    {{-- JS Bawaan --}}
    @include('layouts_admin.js')
</body>

</html>
