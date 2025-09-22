<?php

namespace App\Http\Controllers\Dosen;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasFile;
use App\Models\TugasJawaban;
use App\Models\TugasNilai;
use App\Models\Kelas;
use App\Jobs\SendTugasNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use File;

class TugasDosenController extends Controller
{
    // Middleware untuk memastikan hanya user (admin) yang bisa mengakses
    // Menampilkan daftar tugas
    public function index()
    {
        $dosen = auth()->guard('dosen')->user();
        // Pastikan user sudah login
        if (!$dosen) {
            return redirect()->route('dosen.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tugas = Tugas::with('kelas')->get();
        return view('dosen.tugas.index', compact('tugas'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        $dosen = auth()->guard('dosen')->user();
    $kelas = Kelas::where('dosen_id', $dosen->id)->orderBy('kelas', 'DESC')->get();
        return view('dosen.tugas.create', compact('kelas'));
    }

    // Menyimpan tugas ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'deadline' => 'required|date',
            'pengingat_interval' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $tugas = Tugas::create([
            'dosen_id' => auth()->guard('dosen')->user()->id, // Admin bertindak sebagai pembuat tugas
            'judul' => $request->judul,
            'kelas_id' => $request->kelas_id,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'pengingat_interval' => $request->pengingat_interval
        ]);

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('tugas_files', 'public');
            TugasFile::create([
                'tugas_id' => $tugas->id,
                'file_path' => $path
            ]);
        }


        SendTugasNotification::dispatch($tugas);

    return redirect()->route('kelasdosen.index')->with('success', 'Tugas berhasil dibuat dan notifikasi dikirim.');
    }

    // Menampilkan halaman detail tugas
    public function show($id)
    {
        $tugas = Tugas::with(['files', 'tugasJawaban'])->findOrFail($id);
        return view('dosen.tugas.show', compact('tugas'));
    }

    // Dosen menghapus tugas
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        foreach ($tugas->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Hapus data file dari database
        $tugas->files()->delete();

        // Hapus tugas dari database
        $tugas->delete();

        return back()->with('success', 'Tugas dan file terkait berhasil dihapus.');
    }

    // Dosen melihat jawaban mahasiswa
    public function jawaban($id)
    {
        $tugas = Tugas::with('jawaban.mahasiswa')->findOrFail($id);
        return view('dosen.tugasjawaban', compact('tugas'));
    }

    // Dosen memberi nilai
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        $jawaban = TugasJawaban::findOrFail($id);
        TugasNilai::updateOrCreate(
            ['jawaban_id' => $jawaban->id],
            ['nilai' => $request->nilai,
                    'dosen_id' => auth()->guard('dosen')->id()]
                     // Tambahkan dosen_id]
        );

        $jawaban->update([
            'status' => 'Sudah Dinilai'
        ]);

        return back()->with('success', 'Nilai berhasil diberikan');
    }
    public function kelaslist($kelas_id){
        $kelas = Kelas::with('tugas')->findOrFail($kelas_id);
        return view('dosen.tugas.index', compact('kelas'));
    }
}
