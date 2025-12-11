 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <!-- Backend Bundle JavaScript -->
 <script src="{{ asset('template/assets/js/backend-bundle.min.js') }}"></script>

 <!-- Table Treeview JavaScript -->
 <script src="{{ asset('template/assets/js/table-treeview.js') }}"></script>

 <!-- Chart Custom JavaScript -->
 <script src="{{ asset('template/assets/js/customizer.js') }}"></script>

 <!-- Chart Custom JavaScript -->
 <script async src="{{ asset('template/assets/js/chart-custom.js') }}"></script>

 <!-- app JavaScript -->
 <script src="{{ asset('template/assets/js/app.js') }}"></script>
 @stack('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

 <script>
     $(document).ready(function() {
         $('.delete-btn').on('click', function(e) {
             e.preventDefault();

             var url = $(this).data('url'); // Ambil URL dari tombol
             var id = $(this).data('id'); // Ambil ID dari tombol

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
                         url: url, // Langsung pakai URL dari data-url
                         type: 'DELETE',
                         data: {
                             _token: '{{ csrf_token() }}',
                         },
                         success: function(response) {
                             Swal.fire({
                                 title: 'Dihapus!',
                                 text: 'Data telah berhasil dihapus.',
                                 icon: 'success',
                                 timer: 1500,
                                 showConfirmButton: false
                             }).then(() => {
                                 location
                             .reload(); // reload halaman otomatis
                             });
                         },
                         error: function(error) {
                             Swal.fire(
                                 'Gagal!',
                                 'Terjadi kesalahan saat menghapus data.',
                                 'error'
                             );
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
