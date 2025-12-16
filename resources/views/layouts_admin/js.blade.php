<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Backend Bundle JavaScript -->
<script src="{{ asset('template/assets/js/backend-bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/js/table-treeview.js') }}"></script>
<script src="{{ asset('template/assets/js/customizer.js') }}"></script>
<script async src="{{ asset('template/assets/js/chart-custom.js') }}"></script>
<script src="{{ asset('template/assets/js/app.js') }}"></script>

@stack('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('swal'))
<script>
  Swal.fire(@json(session('swal')));
</script>
@endif

<script>
  // Sidebar toggle (aman kalau element tidak ada)
  const sidebar = document.getElementById("sidebar");
  const toggleBtn = document.getElementById("toggleBtn");
  if (sidebar && toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  }

  // Delete confirm (jQuery)
  $(document).ready(function () {
    $('.delete-btn').on('click', function (e) {
      e.preventDefault();

      var url = $(this).data('url');

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ini tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function () {
              Swal.fire({
                title: 'Dihapus!',
                text: 'Data telah berhasil dihapus.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
              }).then(() => location.reload());
            },
            error: function () {
              Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
            }
          });
        }
      });
    });
  });
</script>

<script>
  // SweetAlert2 based on session
  @if (session('success'))
  Swal.fire({
    icon: 'success',
    title: 'Success',
    text: @json(session('success')),
    timer: 2500,
    showConfirmButton: false
  });
  @endif

  @if (session('error'))
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: @json(session('error')),
    timer: 2500,
    showConfirmButton: false
  });
  @endif
</script>

<script>
  // Loader fade-out (cukup sekali)
  window.addEventListener('load', () => {
    const loader = document.getElementById('custom-loader');
    if (!loader) return;

    loader.style.opacity = '0';
    setTimeout(() => {
      loader.style.visibility = 'hidden';
      loader.style.display = 'none';
    }, 500);
  });

  // Sync tinggi topbar -> padding konten (biar ga ketutup)
  function syncTopbarHeight() {
    const topbar = document.querySelector('.iq-top-navbar');
    if (!topbar) return;
    document.documentElement.style.setProperty('--topbar-h', (topbar.offsetHeight + 10) + 'px');
  }

  window.addEventListener('load', syncTopbarHeight);
  window.addEventListener('resize', syncTopbarHeight);
</script>
