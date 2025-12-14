<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use App\Models\Pengaduan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\KategoriPengaduan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    /**
     * Menampilkan dashboard dengan data statistik.
     */

    public function index(Request $request)
    {
        // Tetapkan filter default (bulan dan tahun saat ini)
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Ambil semua data dashboard berdasarkan filter default
        $data = $this->getFilteredData($month, $year);

        $title = 'Dashboard';

        // Menggabungkan data yang difilter dengan variabel view
        return view('admin.dashboard', array_merge($data, compact('title')));
    }

    // Form Edit Profile
    public function Profile()
    {
        $user = Auth::user();
        $title = 'Profil Saya';
        // Pastikan view profile.blade.php berada di root view atau sesuai path yang benar
        return view('profile', compact('user', 'title'));
    }

    public function getDashboardData(Request $request)
    {
        // 1. Ambil Bulan/Tahun dari request, default ke bulan/tahun sekarang
        $month = $request->input('month');
        $year = $request->input('year');

        if (!$month || !$year) {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        }

        // 2. Panggil metode pengumpul data utama
        $data = $this->getFilteredData($month, $year);

        // 3. Kirim data sebagai JSON
        return response()->json($data);
    }

    /**
     * Mengambil semua data yang dibutuhkan oleh dashboard, difilter berdasarkan bulan dan tahun.
     *
     * @param int $month Bulan yang dipilih.
     * @param int $year Tahun yang dipilih.
     * @return array
     */
    private function getFilteredData($month, $year)
    {
        // 1. DATA PENGADUAN BERDASARKAN KATEGORI (Horizontal Bar Chart)
        $kategoriData = Pengaduan::getPengaduanPerKategori($month, $year);
        $labelsKategori = $kategoriData->pluck('nama')->toArray();
        $dataKategori = $kategoriData->pluck('total')->toArray();

        // 2. DATA PENILAIAN (Donut Chart)
        $ratingData = Pengaduan::getPengaduanPerRating($month, $year);
        // ASUMSI: Kolom 'rating' atau 'penilaian' di database sudah diconvert/dipetakan ke 'label'
        $labelsRating = $ratingData->pluck('label')->toArray();
        $dataRating = $ratingData->pluck('total')->toArray();

        // 3. DATA STATUS / TINDAK LANJUT (Bar Chart - memerlukan data Year, Month, Week)

        // **PERBAIKAN ERROR 'TOO FEW ARGUMENTS'**:
        // Sekarang mengirimkan $month, $year ke semua pemanggilan, termasuk 'year'.
        $statusDataYear = Pengaduan::getPengaduanStatus('year', $month, $year);
        $statusDataMonth = Pengaduan::getPengaduanStatus('month', $month, $year);
        $statusDataWeek = Pengaduan::getPengaduanStatus('week', $month, $year);

        // Label yang ramah pengguna untuk sumbu X chart status
        $readableLabels = ['Menunggu', 'Diproses', 'Selesai'];

        $labelsStatus = [
            'year' => $readableLabels,
            'month' => $readableLabels,
            'week' => $readableLabels,
        ];
        $dataStatus = [
            'year' => $statusDataYear,
            'month' => $statusDataMonth,
            'week' => $statusDataWeek,
        ];

        // 4. DATA RINGKASAN & TABEL
        $totalWarga = Pengaduan::getTotalWarga($month, $year);
        $totalKategoriPengaduan = Pengaduan::getTotalKategoriCount($month, $year);
        $totalPengaduan = Pengaduan::getTotalPengaduanCount($month, $year);
        $wargaTeratas = Pengaduan::getWargaTeratas($month, $year);

        return [
            // Data untuk Grafik Kategori (Horizontal Bar)
            'labelsKategori' => $labelsKategori,
            'dataKategori' => $dataKategori,

            // Data untuk Grafik Penilaian (Donut Chart)
            'labelsRating' => $labelsRating,
            'dataRating' => $dataRating,

            // Data untuk Grafik Status Tindak Lanjut (Bar Chart)
            'labelsStatus' => $labelsStatus,
            'dataStatus' => $dataStatus,

            // Data untuk Ringkasan & Tabel
            'totalWarga' => $totalWarga,
            'totalKategoriPengaduan' => $totalKategoriPengaduan,
            'totalPengaduan' => $totalPengaduan,
            'wargaTeratas' => $wargaTeratas,
        ];
    }

    /** ============================
     * UPDATE PROFIL
     * ============================ */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // **MODIFIKASI: Tambahkan validasi email**
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user->id,
        ]);

        // **MODIFIKASI: Ambil data email**
        $data = $request->only('nama', 'email');

        // **MODIFIKASI: Cek perubahan nama, username, atau email**
        if ($user->nama !== $data['nama'] || $user->email !== $data['email']) {
            $user->update($data);
            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('info', 'Tidak ada perubahan data.');
    }

    /** ============================
     * UPDATE PASSWORD
     * ============================ */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /** ============================
     * UPDATE FOTO PROFIL
     * ============================ */
    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto_user', 'public');
        }

        if ($user->update($data)) {
            return back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        return back()->with('error', 'Foto tidak berhasil diperbarui');
    }
}
