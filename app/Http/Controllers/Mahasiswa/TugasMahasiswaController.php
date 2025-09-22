<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasJawaban;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TugasMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('mahasiswa'); // Pastikan middleware mahasiswa digunakan
    }

    // Menampilkan daftar tugas yang belum dikumpulkan oleh mahasiswa
    public function index(Request $request)
    {
    $mahasiswa = auth()->guard('mahasiswa')->user();
    $kelas_id = $request->kelas_id;

    // Cek apakah mahasiswa tergabung dalam kelas tersebut
    $terdaftar = $mahasiswa->kelas()->where('kelas.id', $kelas_id)->exists();

    if (!$terdaftar) {
        abort(403, 'Anda tidak terdaftar di kelas ini.');
    }

    // Ambil tugas dari kelas tersebut
    $tugasList = \App\Models\Tugas::with(['files', 'tugasJawaban'])
        ->where('kelas_id', $kelas_id)
        ->paginate(10);

    return view('mahasiswa.tugas.index', compact('tugasList'));
    }

    // Menampilkan form untuk submit jawaban
    public function create($tugas_id)
    {
        $tugas = Tugas::findOrFail($tugas_id);
        $mahasiswa = auth()->guard('mahasiswa')->user();

        // Cek apakah mahasiswa sudah mengumpulkan jawaban
        $sudahSubmit = TugasJawaban::where('tugas_id', $tugas->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->exists();

        if ($sudahSubmit) {
            return redirect()->route('tugasmahasiswa.index')->with('error', 'Anda sudah mengumpulkan tugas ini.');
        }

        return view('mahasiswa.tugas.submit', compact('tugas'));
    }

    // Menyimpan jawaban mahasiswa
    public function store(Request $request, $tugas_id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $mahasiswa = auth()->guard('mahasiswa')->user();
        $tugas = Tugas::findOrFail($tugas_id);

        // Cek apakah mahasiswa sudah mengumpulkan tugas ini
        $sudahSubmit = TugasJawaban::where('tugas_id', $tugas->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->exists();

        if ($sudahSubmit) {
            return redirect()->route('tugasmahasiswa.index')->with('error', 'Anda sudah mengumpulkan tugas ini.');
        }

        // Simpan file jawaban
        $path = $request->file('file')->store('jawaban_tugas', 'public');

        // Simpan ke database
        TugasJawaban::create([
            'tugas_id' => $tugas->id,
            'mahasiswa_id' => $mahasiswa->id,
            'file_path' => $path,
            'status' => 'Belum Dinilai',
            'submitted_at' => now()
        ]);

        return redirect()->route('tugasmahasiswa.index')->with('success', 'Jawaban berhasil dikumpulkan.');
    }

    // Menampilkan jawaban mahasiswa
    public function show($tugas_id)
    {
        $mahasiswa = auth()->guard('mahasiswa')->user();
        $tugas = Tugas::findOrFail($tugas_id);

        // Ambil jawaban mahasiswa
        $jawaban = TugasJawaban::where('tugas_id', $tugas->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if (!$jawaban) {
            return redirect()->route('tugasmahasiswa.index')->with('error', 'Anda belum mengumpulkan jawaban untuk tugas ini.');
        }

        return view('mahasiswa.tugas.jawaban', compact('tugas', 'jawaban'));
    }
    public function destroy($tugas_id)
    {
        $jawaban = TugasJawaban::where('tugas_id', $tugas_id)->first();
        if ($jawaban) {
            Storage::disk('public')->delete($jawaban->file_path);
            $jawaban->delete();
        }
        return redirect()->route('tugasmahasiswa.index')->with('success', 'Jawaban berhasil dihapus.');
    }
}
