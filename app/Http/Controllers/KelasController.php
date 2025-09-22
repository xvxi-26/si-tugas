<?php

namespace App\Http\Controllers;
use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kelas_Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::with('matkul', 'dosen')->paginate(10);
        return view('dashboard.kelas.index', compact('kelas', ));
    }

    public function create(){
        $matkul = Matkul::orderBy('nm_mk', 'DESC')->get();
        $dosen = Dosen::orderBy('nama', 'DESC')->get();
        return view('dashboard.kelas.create', compact( 'matkul', 'dosen'));
    }

    public function store(Request $request){
        $request->validate([
            'kelas' => 'required',
            'matkul_id' => 'required|exists:matkul,id',
            'dosen_id' => 'required|exists:dosen,id',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'semester' => 'required',
        ]);

        $kelas=Kelas::create([
            'kelas' => $request->kelas,
            'matkul_id' => $request->matkul_id,
            'dosen_id' => $request->dosen_id,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
        ]);
        return redirect(route('kelas.index'))->with([
            'success' => 'Kelas Berhasil Ditambahkan']);
    }

    public function edit($id){
        $kelas = Kelas::find($id);
        $matkul = Matkul::All();
        $dosen = Dosen::All();
        return view('dashboard.kelas.edit', compact('kelas', 'matkul', 'dosen'));
    }
    public function update(Request $request, $id){
        $request->validate( [
            'kelas' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'semester' => 'required',
        ]);

        $kelas = Kelas::find($id);
        $data = [
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
        ];
        if (!is_null($request->dosen_id)) {
            $data['dosen_id'] = $request->dosen_id;
        }
        if ($request->has('matkul_id', 'dosen_id') && !is_null($request->matkul_id)) {
            $data['matkul_id'] = $request->matkul_id;
        }

        $kelas->update($data);

        return redirect(route('kelas.index'))->with(['success'=>'Kelas Diperbarui']);
    }
    public function show($id){
        $siswa = Mahasiswa::All();
        return view('dashboard.kelas.inputsiswa', compact('siswa', 'id'));
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

    return redirect()->route('kelas.show', $kelasId)->with('success', 'Mahasiswa berhasil ditambahkan ke kelas.');
}
    public function listSiswa($kelas_id)
{
    $kelas = Kelas::with('mahasiswa')->findOrFail($kelas_id);
    return view('dashboard.kelas.listsiswa', compact('kelas'));
}

public function editSiswa($kelas_id, $mahasiswa_id)
{
    $kelas = Kelas::findOrFail($kelas_id);
    $mahasiswa = Mahasiswa::findOrFail($mahasiswa_id);
    return view('dashboard.kelas.edit_siswa', compact('kelas', 'mahasiswa'));
}

public function removeSiswa($kelas_id, $mahasiswa_id)
{
    $kelas = Kelas::findOrFail($kelas_id);
    $kelas->mahasiswa()->detach($mahasiswa_id);

    return redirect()->route('kelas.listsiswa', $kelas_id)->with('success', 'Mahasiswa berhasil dihapus dari kelas.');
}

    public function destroy($id){
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect(route('kelas.index'))->with(['success'=>'Kelas Dihapus']);
    }
}
