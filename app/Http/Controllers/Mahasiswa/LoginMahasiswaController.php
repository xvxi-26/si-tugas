<?php

namespace App\Http\Controllers\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Routing\Controller;

class LoginMahasiswaController extends Controller
{
    public function index(){
        if(auth()->guard('mahasiswa')->check()) return redirect(route('mahasiswa.index'));
        return view('mahasiswa.login');
    }

    public function login(Request $request){
        $request->validate([
            'login' => 'required', // Bisa email atau NIM
            'password' => 'required',
        ]);

        // Cek apakah input adalah email atau NIM
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Mencoba login dengan email atau NIM
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password
        ];
        $credentials['status'] = 1;

        if (auth()->guard('mahasiswa')->attempt($credentials)) {
            return redirect()->route('mahasiswa.index');
        }

        return back()->with('error', 'Email/NIM atau password salah.');
    }

    public function logout(){
        auth()->guard('mahasiswa')->logout();
        return redirect()->route('mahasiswa.login');
    }

}
