<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use App\Models\Lapangan;
use App\Models\Sewa;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function createAdmin()
    {
        return view('admin.create_admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:all,pengelola_lapangan,user',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        Alert::success('Berhasil!', 'Admin baru berhasil ditambahkan.');
        return redirect()->route('admin.index');
    }


    public function index()
    {
        $lapangans = Lapangan::all();
        return view('admin.index', compact('lapangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admincreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ': Attribute harus diisi.'
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'biayaSewa' => 'required',
            'urlFoto' => 'required',
            'deskripsi' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $lapangan = new Lapangan;
        $lapangan->nama = $request->nama;
        $lapangan->alamat = $request->alamat;
        $lapangan->biayasewa = $request->biayaSewa;
        $lapangan->url_foto = $request->urlFoto;
        $lapangan->deskripsi = $request->deskripsi;
        $lapangan->save();
        Alert::success('Berhasil!', 'Sukses menambahkan data lapangan.');
        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lapangan = Lapangan::find($id);
        return view('admin.adminedit', compact('lapangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ': Attribute harus diisi.'
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'biayaSewa' => 'required',
            'urlFoto' => 'required',
            'deskripsi' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $lapangan = Lapangan::find($id);
        $lapangan->nama = $request->nama;
        $lapangan->alamat = $request->alamat;
        $lapangan->biayasewa = $request->biayaSewa;
        $lapangan->url_foto = $request->urlFoto;
        $lapangan->deskripsi = $request->deskripsi;
        $lapangan->save();
        Alert::success('Berhasil!', 'Berhasil update data lapangan.');
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Alert::success('Berhasil!', 'Berhasil hapus data lapangan.');
        Lapangan::find($id)->delete();
        return redirect()->route('admin.index');
    }

    public function reqsewa()
    {
        if (Auth::check()) {
            $sewas = Sewa::all();
            return view('admin/request_sewa_lapangan', compact('sewas'));
        } else {
            return redirect('/login');
        }
    }

    public function accreqsewa(String $id)
    {
        if (Auth::check()) {
            $sewa = Sewa::find($id);
            $sewa->acc = '1';
            $sewa->save();
            return redirect()->route('admin.reqsewa');
        } else {
            return redirect('/login');
        }
    }

    // Tolak request sewa dan menghapus data request
    public function tlkreqsewa($id)
    {
        $sewa = Sewa::find($id);

        if (!$sewa) {
            return redirect()->back()->with('error', 'Request tidak ditemukan.');
        }

        // Logika untuk menolak request sewa
        $sewa->acc = -1; // Contoh logika untuk menolak
        $sewa->save();

        return redirect()->back()->with('success', 'Request sewa berhasil ditolak.');
    }
    public function accsewa()
    {
        if (Auth::check()) {
            $sewas = Sewa::all();
            return view('admin/acc_sewa_lapangan', compact('sewas'));
        } else {
            return redirect('/login');
        }
    }

    // Pembatalan acc sewa
    public function btlaccsewa(String $id)
    {
        if (Auth::check()) {
            $sewa = Sewa::find($id);
            $sewa->acc = '0';
            $sewa->save();
            return redirect()->route('admin.accsewa');
        } else {
            return redirect('/login');
        }
    }

    public function exportPdf(string $id)
    {
        $sewas = Sewa::find($id);
        $customPaper = array(0, 0, 283.80, 567.00,);
        $pdf = PDF::loadView('admin/exportPdf', compact('sewas'))->setPaper($customPaper);
        return $pdf->download('tiket.pdf');
    }
}
