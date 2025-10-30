@extends('layouts_admin.app')

@section('konten')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $title }}</h4>
                </div>
                <button class="btn btn-primary add-list" data-toggle="modal" data-target="#modalUser">
                    <i class="las la-plus mr-3"></i> Tambah User
                </button>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($user as $u)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            @if ($u->foto)
                                                <img src="{{ asset('storage/' . $u->foto) }}" class="rounded img-fluid avatar-40"
                                                    alt="profile">
                                            @else
                                                <img class="rounded img-fluid avatar-40"
                                                    src="{{ asset('template/assets/images/user/01.jpg') }}" alt="profile">
                                            @endif
                                        </td>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->nama }}</td>
                                        <td>
                                            <span class="badge {{ $u->role == 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ ucfirst($u->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center list-action"
                                                style="gap: 5px;">
                                                <button type="button" class="badge bg-success border-0 edit-btn"
                                                    data-id="{{ $u->id }}" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </button>

                                                <a href="{{ route('admin.user.destroy', $u->id) }}"
                                                    class="badge bg-warning delete-btn" data-toggle="tooltip"
                                                    data-placement="top" title="Delete" data-id="{{ $u->id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah / Edit User -->
    <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="formUser" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="_method" id="method">

                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalUserLabel">
                            <i class="las la-user-plus mr-1"></i> Tambah User
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Username</strong></label>
                            <input type="text" name="username" id="username" class="form-control" required
                                placeholder="Masukkan username">
                        </div>

                        <div class="form-group">
                            <label><strong>Nama Lengkap</strong></label>
                            <input type="text" name="nama" id="nama" class="form-control" required
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="form-group">
                            <label><strong>Role</strong></label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="guest">Guest</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><strong>Password</strong></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                        <i class="las la-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Kosongkan saat <strong>edit</strong> jika tidak ingin mengganti password.
                            </small>
                        </div>

                        <div class="form-group">
                            <label><strong>Foto</strong></label>
                            <div class="custom-file">
                                <input type="file" name="foto" id="foto" class="custom-file-input" accept="image/*">
                                <label class="custom-file-label" for="foto">Pilih foto...</label>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Kosongkan saat <strong>edit</strong> jika tidak ingin mengganti foto.
                            </small>
                            <div id="previewFoto" class="mt-3 text-center"></div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="las la-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="las la-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            // Tombol Tambah User
            $('.add-list').on('click', function () {
                $('#modalUserLabel').text('Tambah User');
                $('#formUser').attr('action', "{{ route('admin.user.store') }}");
                $('#method').val('');
                $('#formUser')[0].reset();
                $('#previewFoto').html('');
                $('#password').attr('required', true);
                $('#modalUser').modal('show');
            });

            // ✅ Gunakan delegated event
            $(document).on('click', '.edit-btn', function () {
                const id = $(this).data('id');

                $.ajax({
                    url: "{{ url('admin/user') }}/" + id + "/edit",
                    type: "GET",
                    success: function (data) {
                        if (!data) {
                            Swal.fire('Error', 'Data user tidak ditemukan.', 'error');
                            return;
                        }

                        $('#modalUserLabel').text('Edit User');
                        $('#formUser').attr('action', "{{ url('admin/user') }}/" + id);
                        $('#method').val('PUT');
                        $('#formUser')[0].reset();
                        $('#previewFoto').html('');
                        $('#password').removeAttr('required');

                        // isi form
                        $('#username').val(data.username);
                        $('#nama').val(data.nama);
                        $('#role').val(data.role);

                        if (data.foto) {
                            $('#previewFoto').html(`
                                <img src="/storage/${data.foto}" alt="Foto" width="60" height="60" 
                                     class="rounded-circle" style="object-fit: cover;">
                            `);
                        }

                        // ✅ Buka modal di sini
                        $('#modalUser').modal('show');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Gagal mengambil data user.', 'error');
                    }
                });
            });

        });
    </script>

    <script>
        // Show/hide password
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('la-eye', 'la-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('la-eye-slash', 'la-eye');
            }
        });

        // Ganti label nama file saat pilih foto
        document.getElementById('foto').addEventListener('change', function (e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih foto...';
            e.target.nextElementSibling.innerText = fileName;

            // Preview foto
            const preview = document.getElementById('previewFoto');
            preview.innerHTML = '';
            if (e.target.files[0]) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(e.target.files[0]);
                img.classList.add('img-thumbnail', 'mt-2');
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.objectFit = 'cover';
                preview.appendChild(img);
            }
        });
    </script>
@endpush