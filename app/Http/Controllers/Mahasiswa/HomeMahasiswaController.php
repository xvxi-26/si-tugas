<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeMahasiswaController extends Controller
{
    public function index(){
        return view('mahasiswa.home.index');
    }
    public function verifMahasiswaRegistration($token){
        $mahasiswa = Mahasiswa::where( 'activate_token',$token)->first();
        if($mahasiswa){
            $mahasiswa->update([
                'activate_token' => null,
                'status' => 1
            ]);
            return redirect(route('mahasiswa.login'))->with([
                'success' => 'Akun Berhasil Diverifikasi'
            ]);
        }
        return redirect(route('mahasiswa.login'))->with([
            'error' => 'Token Tidak Valid'
        ]);
    }
    public function Chatid(){
        return view('mahasiswa.home.telegram');
    }
    public function updateChatId(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string|max:50'
        ]);

        $mahasiswa = auth()->guard('mahasiswa')->user(); // Ambil user yang sedang login
        $mahasiswa->update([
            'chat_id' => $request->chat_id
        ]);

        return redirect()->back()->with('success', 'Chat ID berhasil diperbarui!');
    }
}
