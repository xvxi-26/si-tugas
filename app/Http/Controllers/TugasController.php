<?php

namespace App\Http\Controllers;
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

class TugasController extends Controller
{
    // Middleware untuk memastikan hanya user (admin) yang bisa mengakses
    // Menampilkan daftar tugas
    public function index()
    {
        $tugas = Tugas::with('kelas')->get();
        return view('dashboard.tugas.index', compact('tugas'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        $kelas = Kelas::orderBy('kelas', 'DESC')->get();
        return view('dashboard.tugas.create', compact('kelas'));
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
            'dosen_id' => Auth::id(), // Admin bertindak sebagai pembuat tugas
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

    return redirect()->route('kelas.index')->with('success', 'Tugas berhasil dibuat dan notifikasi dikirim.');
    }

    // Menampilkan halaman detail tugas
    public function show($id)
    {
        $tugas = Tugas::with(['files', 'tugasJawaban'])->findOrFail($id);
        return view('dashboard.tugas.show', compact('tugas'));
    }

    // Admin menghapus tugas
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

    // Admin melihat jawaban mahasiswa
    public function jawaban($id)
    {
        $tugas = Tugas::with('jawaban.mahasiswa')->findOrFail($id);
        return view('tugas.jawaban', compact('tugas'));
    }

    // Admin memberi nilai
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        $jawaban = TugasJawaban::findOrFail($id);
        $tugas = $jawaban->tugas;
        $dosen_id = $tugas->kelas->dosen_id;
        TugasNilai::updateOrCreate(
            ['jawaban_id' => $jawaban->id],
            ['nilai' => $request->nilai,
                    'dosen_id' => $dosen_id]


        );
        $jawaban->update([
            'status' => 'Sudah Dinilai'
        ]);

        return back()->with('success', 'Nilai berhasil diberikan');
    }
    public function kelaslist($kelas_id){
        $kelas = Kelas::with('tugas')->findOrFail($kelas_id);
        return view('dashboard.tugas.index', compact('kelas'));
    }
}
