<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::paginate(10);
        return view('dashboard.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('dashboard.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'angkatan' => 'required|numeric',
            'nomor_telepon' => 'required|numeric|unique:mahasiswa,nomor_telepon',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required',
        ]);

        Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activate_token' => null, // Admin langsung mengaktifkan akun
            'status' => 1,
        ]);

        return redirect()->route('mahasiswaadmin.index')->with('success', 'Mahasiswa berhasil ditambahkan dan langsung aktif.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('dashboard.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|numeric|unique:mahasiswa,nim,' . $id,
            'angkatan' => 'required|numeric',
            'nomor_telepon' => 'required|numeric|unique:mahasiswa,nomor_telepon,' . $id,
            'email' => 'required|email|unique:mahasiswa,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->nomor_telepon = $request->nomor_telepon;
        $mahasiswa->email = $request->email;

        if ($request->password) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswaadmin.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('mahasiswaadmin.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
