<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Menampilkan form pendaftaran owner.
     */
    public function create()
    {
        return view('owner.register'); // Pastikan view ini sudah dibuat
    }

    /**
     * Memproses form pendaftaran owner.
     */
    public function store(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'business_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);


        // Ubah peran pengguna menjadi 'owner'
        $user = auth()->user();
        $user->role = 'owner';
        $user->save();

        // Tambahkan logika tambahan jika perlu, seperti menyimpan data bisnis di tabel lain

        // Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Berhasil mendaftar sebagai owner!');
    }
}
