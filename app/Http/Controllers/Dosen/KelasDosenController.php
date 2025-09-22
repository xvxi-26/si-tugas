<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use DB;

class KelasDosenController extends Controller
{
    public function index()
{
    $dosen = auth()->guard('dosen')->user();


    // Pastikan user sudah login
    if (!$dosen) {
        return redirect()->route('dosen.login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $kelas = Kelas::with('matkul', 'dosen')
                  ->where('dosen_id', $dosen->id)
                  ->paginate(10);

    return view('dosen.kelas.index', compact('kelas'));
}


public function create(){
    $matkul = Matkul::orderBy('nm_mk', 'DESC')->get();
    return view('dosen.kelas.create', compact('matkul'));
}
public function store(Request $request)
{
    $request->validate([
        'kelas' => 'required',
        'matkul_id' => 'required|exists:matkul,id',
        'jurusan' => 'required',
        'angkatan' => 'required',
        'semester' => 'required',
    ]);
    Kelas::create([
        'kelas' => $request->kelas,
        'matkul_id' => $request->matkul_id,
        'dosen_id' => auth()->guard('dosen')->user()->id, // Set dosen_id sesuai yang login
        'jurusan' => $request->jurusan,
        'angkatan' => $request->angkatan,
        'semester' => $request->semester,
    ]);
    return redirect()->route('kelasdosen.index')->with('success', 'Kelas Berhasil Ditambahkan');
}

    public function edit($id){
        $kelas = Kelas::where('id', $id)
                  ->where('dosen_id', auth()->guard('dosen')->user()->id) // Pastikan hanya dosen terkait
                  ->firstOrFail(); // Jika tidak ditemukan, akan 404
        $matkul = Matkul::All();
    return view('dosen.kelas.edit', compact('kelas', 'matkul'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'kelas' => 'required',
            'matkul_id' => 'required|exists:matkul,id',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'semester' => 'required',
        ]);
        $kelas = Kelas::where('id', $id)
                  ->where('dosen_id', auth()->guard('dosen')->user()->id) // Pastikan hanya dosen terkait
                  ->firstOrFail(); // Jika tidak ditemukan, akan 404
        $kelas->update([
            'kelas' => $request->kelas,
            'matkul_id' => $request->matkul_id,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
        ]);
        return redirect()->route('kelasdosen.index')->with('success', 'Kelas Berhasil Diperbarui');
    }

    public function destroy($id){
        $kelas = Kelas::where('id', $id)
                  ->where('dosen_id', auth()->guard('dosen')->user()->id) // Pastikan hanya dosen terkait
                  ->firstOrFail(); // Jika tidak ditemukan, akan 404
        $kelas->delete();
        return redirect()->route('kelasdosen.index')->with('success', 'Kelas Berhasil Dihapus');
    }

    public function listSiswa($kelas_id){
        $kelas = Kelas::with('mahasiswa')->findOrFail($kelas_id);
        return view('dosen.kelas.listsiswa', compact('kelas'));
    }
    public function removeSiswa($kelas_id, $mahasiswa_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $kelas->mahasiswa()->detach($mahasiswa_id);

        return redirect()->route('kelasdosen.listsiswa', $kelas_id)->with('success', 'Mahasiswa berhasil dihapus dari kelas.');
    }
    public function show($id){
        $siswa = Mahasiswa::All();
        return view('dosen.kelas.inputsiswa', compact('siswa', 'id'));
    }
    public function inputSiswa(Request $request, $kelasId)
{
    $request->validate([
        'mahasiswa_id' => 'required|array',
        'mahasiswa_id.*' => 'exists:mahasiswa,id',
    ]);

    $kelas = Kelas::with('matkul')->findOrFail($kelasId);
    $matkulId = $kelas->matkul_id;

    $sudahTerdaftar = [];

    foreach ($request->mahasiswa_id as $mahasiswaId) {
        // Cek apakah mahasiswa sudah terdaftar di kelas lain dengan matkul yang sama
        $sudahAda = DB::table('kelas_mahasiswa')
            ->join('kelas', 'kelas.id', '=', 'kelas_mahasiswa.kelas_id')
            ->where('kelas.matkul_id', $matkulId)
            ->where('kelas_mahasiswa.mahasiswa_id', $mahasiswaId)
            ->exists();

        if ($sudahAda) {
            $mahasiswa = Mahasiswa::find($mahasiswaId);
            $sudahTerdaftar[] = $mahasiswa ? $mahasiswa->nama . ' (' . $mahasiswa->nim . ')' : 'ID: ' . $mahasiswaId;
        }
    }

    if (!empty($sudahTerdaftar)) {
        return redirect()->back()->with('error', 'Mahasiswa berikut sudah terdaftar pada mata kuliah "' . $kelas->matkul->nm_mk . ' " ' . implode(' ', $sudahTerdaftar));
    }

    // Simpan jika aman
    foreach ($request->mahasiswa_id as $mahasiswaId) {
        DB::table('kelas_mahasiswa')->insert([
            'kelas_id' => $kelasId,
            'mahasiswa_id' => $mahasiswaId
        ]);
    }

    return redirect()->route('kelasdosen.show', $kelasId)->with('success', 'Mahasiswa berhasil ditambahkan ke kelas.');
}


}
