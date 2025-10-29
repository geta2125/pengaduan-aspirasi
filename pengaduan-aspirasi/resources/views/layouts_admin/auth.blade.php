<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bina Desa | {{ $title }}</title>

    {{-- start css --}}
    @include('layouts_admin.css')
    {{-- end css --}}
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            @yield('konten')
        </section>
    </div>

    {{-- start js --}}
    @include('layouts_admin.js')
    {{-- end js --}}
