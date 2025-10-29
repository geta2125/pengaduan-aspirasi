@extends('layouts_guest.app')

@section('konten')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                        <h4 class="mb-0"><i class="bi bi-star-fill me-2"></i>Penilaian Layanan</h4>
                        <p class="mb-0 lead">{{ $pengaduan->judul }}</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="penilaianForm" action="{{ route('guest.penilaian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->pengaduan_id }}">
                            <div class="mb-5 text-center">
                                <label for="rating" class="form-label fs-5 fw-bold mb-3">Seberapa Puas Anda dengan
                                    Penanganan Pengaduan Ini?</label>
                                <div class="d-flex justify-content-center star-rating" id="rating-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none">
                                        <label for="star{{ $i }}" class="fs-1 text-muted me-2" data-value="{{ $i }}">
                                            <i class="bi bi-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                <p class="mt-2 text-muted" id="rating-label">Pilih rating Anda (1-5)</p>
                                <input type="hidden" id="selectedRating" value="">
                            </div>
                            <div class="mb-4">
                                <label for="komentar" class="form-label fw-bold">Komentar dan Masukan Anda
                                    (opsional)</label>
                                <textarea name="komentar" id="komentar" class="form-control" rows="4"
                                    placeholder="Berikan komentar atau masukan Anda di sini..."></textarea>
                            </div>
                            <div class="d-flex justify-content-between pt-3">
                                <a href="{{ route('guest.penilaian.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="button" class="btn btn-primary" onclick="previewData()">
                                    <i class="bi bi-eye me-1"></i> Preview Penilaian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="previewModalLabel"><i class="bi bi-check-circle-fill me-2"></i>Konfirmasi
                        Penilaian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold">Pengaduan:</p>
                    <p>{{ $pengaduan->judul }}</p>
                    <hr>
                    <p class="fw-bold">Rating Anda:</p>
                    <p id="previewRatingText" class="fs-4 text-warning"></p>
                    <hr>
                    <p class="fw-bold">Komentar:</p>
                    <p id="previewKomentar" class="fst-italic text-muted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button type="button" class="btn btn-success" onclick="submitForm()">
                        <i class="bi bi-save me-1"></i> Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .star-rating label {
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }

        .star-rating label i {
            color: #ccc;
        }

        .star-rating input:checked~label i,
        .star-rating label:hover i,
        .star-rating label:hover~label i {
            color: orange !important;
        }

        .star-rating input:checked+label i,
        .star-rating input:checked~label i {
            color: gold !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function previewData() {
            const rating = document.getElementById('selectedRating').value || 0;
            const komentar = document.getElementById('komentar').value.trim() || 'Tidak ada komentar';

            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= parseInt(rating) ?
                    '<i class="bi bi-star-fill text-warning me-1"></i>' :
                    '<i class="bi bi-star text-warning me-1"></i>';
            }

            document.getElementById('previewRatingText').innerHTML = `(${rating}/5) ${starsHtml}`;
            document.getElementById('previewKomentar').innerText = komentar;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }

        function submitForm() {
            document.getElementById('penilaianForm').submit();
        }

        // Interactivity Star Rating
        document.addEventListener('DOMContentLoaded', () => {
            const ratingLabels = document.querySelectorAll('.star-rating label');
            const selectedRatingInput = document.getElementById('selectedRating');
            const ratingLabelText = document.getElementById('rating-label');
            const ratingMap = { 1: 'Sangat Buruk 😞', 2: 'Buruk 😐', 3: 'Cukup Baik 🙂', 4: 'Baik 👍', 5: 'Sangat Baik! 🌟' };

            ratingLabels.forEach(label => {
                const radioInput = document.getElementById(`star${label.dataset.value}`);
                label.addEventListener('click', () => {
                    selectedRatingInput.value = radioInput.value;
                    ratingLabelText.innerText = ratingMap[radioInput.value];
                    radioInput.checked = true;
                });
                label.addEventListener('mouseover', () => {
                    if (!selectedRatingInput.value) ratingLabelText.innerText = ratingMap[label.dataset.value];
                });
                label.addEventListener('mouseout', () => {
                    ratingLabelText.innerText = selectedRatingInput.value ? ratingMap[selectedRatingInput.value] : 'Pilih rating Anda (1-5)';
                });
            });
        });
    </script>
@endpush