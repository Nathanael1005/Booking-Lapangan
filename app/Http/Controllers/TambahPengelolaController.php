<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class PengelolaController extends Controller
{
    /**
     * Menampilkan daftar pengelola lapangan.
     */
    public function index()
    {
        $pengelolas = User::where('role', 'pengelola_lapangan')->get();
        return view('admin.acc_sewa_lapangan', compact('pengelolas'));
    }

    /**
     * Menampilkan form untuk menambahkan pengelola lapangan.
     */
    public function create()
    {
        return view('pengelola.create');
    }

    /**
     * Menyimpan pengelola lapangan yang baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        // Jika validasi gagal, kembalikan dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat pengguna baru dengan peran 'pengelola_lapangan'
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'pengelola_lapangan';
        $user->save();

        // Tampilkan pesan sukses dan arahkan kembali ke halaman sebelumnya
        Alert::success('Berhasil!', 'Sukses menambahkan pengelola lapangan.');
        return redirect()->route('pengelola.index');
    }

    /**
     * Menghapus pengelola lapangan dari database.
     */
    public function destroy($id)
    {
        // Cari pengguna berdasarkan ID
        $pengelola = User::find($id);

        // Jika pengguna tidak ditemukan, tampilkan pesan error
        if (!$pengelola) {
            Alert::error('Error!', 'Pengguna tidak ditemukan.');
            return redirect()->route('pengelola.index');
        }

        // Hapus pengguna dari database
        $pengelola->delete();

        // Tampilkan pesan sukses dan arahkan kembali ke halaman sebelumnya
        Alert::success('Berhasil!', 'Sukses menghapus pengelola lapangan.');
        return redirect()->route('pengelola.index');
    }
}
