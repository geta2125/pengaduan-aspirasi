<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>BinaDesa | {{ $title }}</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('template_guest/assets/images/favicon.ico') }}" />

  <link rel="stylesheet" href="{{ asset('template_guest/assets/css/backend-plugin.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template_guest/assets/css/backend.css?v=1.0.1') }}">
  <link rel="stylesheet"
    href="{{ asset('template_guest/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet"
    href="{{ asset('template_guest/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template_guest/assets/vendor/remixicon/fonts/remixicon.css') }}">
</head>

<body class=" ">
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

  <!-- Backend Bundle JavaScript -->
  <script src="{{ asset('template_guest/assets/js/backend-bundle.min.js') }}"></script>

  <!-- Chart Custom JavaScript -->
  <script src="{{ asset('template_guest/assets/js/customizer.js') }}"></script>


  <!-- app JavaScript -->
  <script src="{{ asset('template_guest/assets/js/app.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Script untuk toggle password --}}
  <script>
    document.querySelector('.toggle-password').addEventListener('click', function () {
      const passwordInput = document.getElementById('password');
      const icon = document.getElementById('toggleIcon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    });
  </script>

  <script>
    // SweetAlert2 based on session
    @if (session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
      });
    @endif

    @if (session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 2500,
        showConfirmButton: false
      });
    @endif
  </script>
</body>

</html>